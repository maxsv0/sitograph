<?php
// exit if already installed
if (MSV_INSTALED) {
	return true;
}

if (!empty($_SESSION["msv_install_step"])) {
	$install_step = (int)$_SESSION["msv_install_step"];
} else {
	$install_step = 1;
}

$website = $this->website;
$website->page = array(1);
$website->template = "default";
$website->pageTemplate = "install.tpl";
$website->pageTemplatePath = ABS_TEMPLATE."/default/install.tpl";

MSV_Include("/content/js/jquery.min.js");
MSV_Include("/content/css/bootstrap.min.css");
MSV_Include("/content/js/bootstrap.min.js");

$configListNames = array(
	"LANGUAGES",
	"DB_HOST","DB_LOGIN","DB_PASSWORD","DB_NAME",
	"ABS","DB_REQUIRED","DATE_FORMAT","PROTOCOL","MASTERHOST",
	"UPLOAD_FILES_PATH","CONTENT_URL","PHP_HIDE_ERRORS",
	"DEBUG","DEBUG_LOG","SITE_CLOSED","SHOW_ADMIN_MENU",
	"PHP_LOCALE","PHP_TIMEZONE","DATABATE_ENCODING",
	"FORSE_TRAILING_SLASH","SUBDOMAIN_LANGUAGES","REP",
	"USER_HASH_PASSWORD","USER_IGNORE_PRIVILEGES","SMARTY_DIR"
);


/// TODO:
// + dublicate template and set theme name // each lang??
//

if (!empty($_REQUEST["install_reset"])) {
	$_SESSION["msv_install_step"] = $install_step = 1;
	$_SESSION["user_id"] = $_SESSION["user_email"] = "";
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_email"]);
	$website->outputRedirect("/");
}

if (!empty($_REQUEST["install_step"]) && empty($website->messages["error"])) {
	$_REQUEST["install_step"] = (int)$_REQUEST["install_step"];
	
	if ($_REQUEST["install_step"] === 2) {
		$_SESSION["user_id"] = $_SESSION["user_email"] = "";
	}
	if ($_REQUEST["install_step"] === 3) {

		if (empty($_REQUEST["msv_LANGUAGES"])) {
			$website->messages["error"][] = "Please select languages";
		} else {

			$configList = array();
			$configPHP = "<?php \n";
			
			foreach ($configListNames as $name) {
				$valueCurrent = constant($name);
				
				if (array_key_exists("msv_".$name, $_REQUEST)) {
					$value = $_REQUEST["msv_".$name];
				} else {
					$value = $valueCurrent;
				}
				
				if (is_bool($valueCurrent)) {
					$value = (int)$value;
					if ($value) {
						$configPHP .= "define(\"".$name."\", true);\n";
					} else {
						$configPHP .= "define(\"".$name."\", false);\n";
					}
					
				} elseif (is_int($valueCurrent)) {
					$value = (int)$value;
					$configPHP .= "define(\"".$name."\", $value);\n";
				} elseif (is_string($valueCurrent)) {
					$configPHP .= "define(\"".$name."\", \"".$value."\");\n";
				}
				
				$configList[$name] = $value;
			}
			
			$resultFile = @file_put_contents(ABS."/config.php", $configPHP);

			if ($resultFile) {
				$website->messages["success"][] = "".ABS."/config.php successfuly created";
			} else {
				$website->messages["error"][] = "ERROR: Can't write to ".ABS."/config.php";
			}
		}
	}
	
	if ($_REQUEST["install_step"] === 4) {
		
		if (empty($website->messages["error"]) && 
			!empty($_REQUEST["modules_local"]) && is_array($_REQUEST["modules_local"])) {
			foreach ($_REQUEST["modules_local"] as $module) {
				$obj = $website->{$module};

				if (!$obj->started) {
					$website->runModule($module);
				}
				if (!empty($obj->tables)) {
					$tableList = $obj->tables;
					
					if (!empty($tableList)) {
						
						foreach ($tableList as $tableName => $tableInfo) {
							$result = API_createTable($tableName);
						}
					}
				}
			}
			foreach ($_REQUEST["modules_local"] as $module) {
				$obj = $website->{$module};
				$obj->runInstallHook();
			}
			
			
			if(!empty($_REQUEST["modules_remote"]) && is_array($_REQUEST["modules_remote"])) {
				foreach ($_REQUEST["modules_remote"] as $module) {
					MSV_installModule($module, false);
				}
			}
			
			
		} else {
			// no modules selected to be installed
			// ok? sure
		}
		
		// create superadmin account
		if (!empty($_REQUEST["admin_create"])) {
			if (!empty($_REQUEST["admin_login"]) && !empty($_REQUEST["admin_password"])) {
				// during install to not send emails
				MSV_setConfig("users_registration_email", false);

				$item = array(
				    "email" => $_REQUEST["admin_login"],
				    "password" => $_REQUEST["admin_password"],
				    "email_verified" => 1,
				    "name" => "Admin",
				    "access" => "superadmin",
                    "iss" => "install",
                );

				// add admin account
				$resultUser = User_Add($item, 0, 0);
				if ($resultUser["ok"] && !empty($resultUser["insert_id"])) {
					$_SESSION['user_id'] = $resultUser["insert_id"];
					$_SESSION['user_email'] = $_REQUEST["admin_login"];
					
					// store website admin email
					MSV_setConfig("admin_email", $_REQUEST["admin_login"], true, "*");
					MSV_setConfig("support_email", $_REQUEST["admin_login"], true, "*");
				} else {
					$website->messages["error"][] = "Error adding administrator account: ".$resultUser["msg"];
				}
				
			} else {
				$website->messages["error"][] = "Please enter login and password";
			}
		}
		
		
		
	}
	
	
	if ($_REQUEST["install_step"] === 5) {
		
		// finish installation
		
		// reset step
		$_SESSION["msv_install_step"] = $install_step = 0;
		
		// copy design "default" to "custom"
		// TODO: >>>>>>>

		// redirect to homepage
		$website->outputRedirect("/");
	}
	
	// if no errors, go to next step
	if (empty($website->messages["error"]) && !empty($install_step)) {
		$install_step = $_REQUEST["install_step"];
		$_SESSION["msv_install_step"] = $install_step;
		
		
		if (!empty($_REQUEST["install_auto"])) {
			$queryString = str_replace("install_step=".$install_step, "install_step=".($install_step+1), $_SERVER["QUERY_STRING"]);
			
			$website->outputRedirect("/?".$queryString);
		} else {
			$website->outputRedirect("/");
		}
		
	}
}

if ($install_step === 2) {
	if (file_exists(ABS."/config.php")) {
		$website->messages["error"][] = "ERROR: <b>".ABS."/config.php</b> already exists and will be overwritten!";
		
		if (!is_writable(ABS."/config.php")) {
			$website->messages["error"][] = "ERROR: <b>".ABS."/config.php</b> is not writable";
		}
	}
}

if ($install_step === 3) {
	if (empty($website->config["db"])) {
		$website->messages["error"][] = "ERROR: Database connection not established.";
	} else {
		$website->messages["success"][] = "SUCCESS: Database connection established.";
	}
	if (!is_writable(SMARTY_DIR."cache")) {
		$website->messages["error"][] = "ERROR: <b>".SMARTY_DIR."cache</b> is not writable";
	} else {
		$website->messages["success"][] = "SUCCESS: smarty/cache is writable";
	}
}

if ($install_step === 2) {
	$configList = array();
	foreach ($configListNames as $name) {
		$value = constant($name);
		if (is_bool($value)) {
			$value = $value ? 1 : 0;
		}
		$configList[$name] = $value;
	}
	$website->config["configList"] = $configList;
}
if ($install_step === 3) {
	$modulesList = array();
	foreach ($website->modules as $module) {
		if ($module === "install") continue;
		$modulesList[$module] = array();
	}
	
	$modulesListRemote = array(
	);
	
	// sort lists
    ksort($modulesList);
	ksort($modulesListRemote);
	
	$website->config["modulesList"] = $modulesList;
	$website->config["modulesListRemote"] = $modulesListRemote;
	
	$website->config["admin_login"] = "admin@".HOST;
	$website->config["admin_password"] = MSV_PasswordGenerate();
}

if (!empty($install_step)) {
	$website->config["install_step"] = $install_step;
}

$website->outputDebug();
$website->outputPage();

