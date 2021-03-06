<?php
// exit if already installed
if (MSV_INSTALED) {
    return true;
}

// set install step. start with 1
if (!empty($_SESSION["msv_install_step"])) {
    $install_step = (int)$_SESSION["msv_install_step"];
} else {
    $install_step = 1;
}

// prepare template for outpur
$website = $this->website;
$website->page = array(1);
$website->template = "default";
$website->pageTemplate = "install.tpl";
$website->pageTemplatePath = ABS_TEMPLATE."/default/install.tpl";

// include extra JS/CSS
msv_include(CONTENT_URL."/js/jquery.min.js");
msv_include(CONTENT_URL."/css/bootstrap.min.css");
msv_include(CONTENT_URL."/js/bootstrap.min.js");

$configListNames = array(
    "LANGUAGES",
    "DB_HOST","DB_LOGIN","DB_PASSWORD","DB_NAME",
    "ABS","DB_REQUIRED","DATE_FORMAT","PROTOCOL","MASTERHOST",
    "UPLOAD_FILES_PATH","CONTENT_URL","PHP_HIDE_ERRORS",
    "DEBUG","DEBUG_LOG","SITE_CLOSED","SHOW_ADMIN_MENU",
    "PHP_LOCALE","PHP_TIMEZONE","DATABASE_ENCODING",
    "JS_BEFORE_BODY","SUBDOMAIN_LANGUAGES","REP",
    "USER_HASH_PASSWORD","USER_IGNORE_PRIVILEGES","SMARTY_DIR",
    "ADMIN_URL"
);

/// TODO:
// + dublicate template and set theme name // each lang??
//

// 'reset' btn click
if (!empty($_REQUEST["install_reset"])) {
    $_SESSION["msv_install_step"] = $install_step = 0;
    $_SESSION["user_id"] = $_SESSION["user_email"] = "";
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_email"]);
    $website->outputRedirect("/");
}

// 'next step' btn click
if (!empty($_REQUEST["install_step"]) && empty($website->messages["error"])) {
    $_REQUEST["install_step"] = (int)$_REQUEST["install_step"];

    // action for step 2
    if ($_REQUEST["install_step"] === 2) {
        $_SESSION["user_id"] = $_SESSION["user_email"] = "";
    }

    // action for step 3
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
                $website->messages["success"][] = "".ABS."/config.php successfully created";
            } else {
                $website->messages["error"][] = "ERROR: Can't write to ".ABS."/config.php";
            }
        }
    }

    // action for step 4
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
                            $result = db_create_table($tableName);
                        }
                    }
                }
            }
            foreach ($_REQUEST["modules_local"] as $module) {
                $obj = $website->{$module};
                $obj->runInstallHook();
            }

            if (!empty($_REQUEST["modules_remote_str"])) {
                $_REQUEST["modules_remote"] = array_merge((array)$_REQUEST["modules_remote"], explode(",", $_REQUEST["modules_remote_str"]));
            }

            $remoteInstalled = "";
            if(!empty($_REQUEST["modules_remote"]) && is_array($_REQUEST["modules_remote"])) {
                foreach ($_REQUEST["modules_remote"] as $module) {
                    msv_install_module($module, false);
                }
                $remoteInstalled = implode(",", $_REQUEST["modules_remote"]);
            }

        } else {
            // no modules selected to be installed
            // ok? sure
        }

        // create dev account
        if (!empty($_REQUEST["admin_create"])) {
            if (!empty($_REQUEST["admin_login"]) && !empty($_REQUEST["admin_password"])) {

                $access_token = substr(md5(time()), 0, 16);

                $item = array(
                    "email" => $_REQUEST["admin_login"],
                    "password" => $_REQUEST["admin_password"],
                    "email_verified" => 1,
                    "name" => "Admin",
                    "access" => $_REQUEST["admin_access"],
                    "iss" => "install",
                    "access_token" => $access_token,
                );
                $_SESSION['user_info'] = $item;

                // add admin account
                $resultUser = msv_add_user($item);
                if ($resultUser["ok"] && !empty($resultUser["insert_id"])) {
                    $_SESSION['user_id'] = $resultUser["insert_id"];
                    $_SESSION['user_email'] = $_REQUEST["admin_login"];

                    // store website admin email
                    msv_set_config("admin_email", $_REQUEST["admin_login"], true, "*");
                    msv_set_config("support_email", $_REQUEST["admin_login"], true, "*");

                    // add cron job:
                    $item = array(
                        "name" => "Update All Modules",
                        "url_local" => "/api/core/update-all/?access_token=".$access_token,
                        "status" => "active",
                        "type" => "daily",
                    );
                    $resultRun = msv_add_cron($item);
                } else {
                    $website->messages["error"][] = "Error adding administrator account: ".$resultUser["msg"];
                }

            } else {
                $website->messages["error"][] = "Please enter login and password";
            }
        }

    }

    // action for step 5
    if ($_REQUEST["install_step"] === 5) {

        // run install hooks for remote_installed modules
        if (!empty($_REQUEST["remote_installed"])) {
            $list = explode(",", $_REQUEST["remote_installed"]);
            if (!empty($list)) {
                foreach ($list as $module) {
                    $obj = $website->{$module};

                    if (!$obj->started) {
                        $website->runModule($module);
                    }
                    if (!empty($obj->tables)) {
                        $tableList = $obj->tables;

                        if (!empty($tableList)) {

                            foreach ($tableList as $tableName => $tableInfo) {
                                $result = db_create_table($tableName);
                            }
                        }
                    }
                }
                foreach ($list as $module) {
                    $obj = $website->{$module};
                    $obj->runInstallHook();
                }
            }
        }

        // finish installation
        // update settings
        $result = db_get_list(TABLE_SETTINGS);
        $list = $result["data"];
        foreach ($list as $row) {
            $name = $row["param"];
            $valueCurrent = $row["value"];
            if (array_key_exists("s_".$name, $_REQUEST)) {
                $value = $_REQUEST["s_".$name];

                if ($valueCurrent !== $value) {
                    db_update(TABLE_SETTINGS, "value", "'".db_escape($value)."'", " `param` = '".$name."'");
                    msv_set_config($name, $value);
                }
            }
        }

        $sendFrom = msv_get_config("email_from");
        if (empty($sendFrom)) {
            msv_set_config("email_from", "install@sitograph");
        }

        // reset step
        $_SESSION["msv_install_step"] = $install_step = 0;

        if (!empty($_REQUEST["admin_notify"])) {
            if (!empty($_SESSION['user_info']) && is_array($_SESSION['user_info'])) {
                $resultMail = msv_email_template("user_registration", $_SESSION['user_info']["email"], $_SESSION['user_info']);
            }
            unset($_SESSION['user_info']);
        }

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
            if (!empty($remoteInstalled)) {
                $website->outputRedirect("/?remote_installed=".$remoteInstalled);
            } else {
                $website->outputRedirect("/");
            }
        }

    }
}

// validation, step 2
if ($install_step === 2) {
    if (file_exists(ABS."/config.php")) {
        $website->messages["error"][] = "Warning: <b>".ABS."/config.php</b> will be overwritten";

        if (!is_writable(ABS."/config.php")) {
            $website->messages["error"][] = "ERROR: <b>".ABS."/config.php</b> is not writable";
        }
    }
}

// validation, step 3
if ($install_step === 3) {
    if (empty($website->config["db"])) {
        $website->messages["error"][] = "ERROR: Database connection not established.";
    } else {
        $website->messages["success"][] = "SUCCESS: Database connection established.";
    }
}

// prepare initial data, step 2
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

// prepare initial data, step 3
if ($install_step === 3) {
    $modulesList = array();

    // sort modules according to activationLevel
    // this is needed cause modules will be installed in same order
    for ($i = 1; $i <= 10; $i++) {
        foreach ($website->modules as $module) {
            if ($module === "install") continue;

			$moduleEnabled = true;
            if (strpos($module, "theme-") === 0) {
            	//check if any theme already enabled
				foreach ($modulesList as $mName => $item) {
					if (strpos($mName, "theme-") === 0) {
						$moduleEnabled = false;
					}
				}
			}

            $objModule = msv_get("website.".$module);
            if (empty($objModule)) {
                continue;
            }
            $lvl = $objModule->activationLevel;

            $info = array(
            	"enabled" => $moduleEnabled,
			);

            if ($lvl == $i) {
                $modulesList[$module] = $info;
            }
        }
    }

    $modulesListRemote = array(
    );

    // sort lists
    //ksort($modulesList);
    ksort($modulesListRemote);

    $website->config["modulesList"] = $modulesList;
    $website->config["modulesListRemote"] = $modulesListRemote;

    // admin login has to be valid email (and contain dot)
    if (strpos(HOST, ".") === false) {
        $website->config["admin_login"] = "admin@".HOST.".local";
    } else {
        $website->config["admin_login"] = "admin@".HOST;
    }

    $website->config["admin_password"] = msv_generate_password();
    $website->config["admin_access"] = "admin";
}

// prepare initial data, step 4
if ($install_step === 4) {
    $result = db_get_list(TABLE_SETTINGS);
    $list = $result["data"];
    $website->config["settings"] = $list;

    if (!empty($_REQUEST["remote_installed"])) {
        $website->config["remote_installed"] = $_REQUEST["remote_installed"];
    }
}

if (!empty($install_step)) {
    $website->config["install_step"] = $install_step;
}

// output template
$website->outputDebug();
echo $website->outputPage();
exit();
