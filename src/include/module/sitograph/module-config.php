<?php

MSV_MessageError("<b>WARNING!</b> PLEASE NOTE: After clicking the <b>Save</b> button changes will be made directly to the <b>config.php</b> file. <br><b>THIS CAN CAUSE WEBSITE STOP FUNCTIONING.</b>");



$configListNames = array(
	"ABS", "LANGUAGES",
	"DB_HOST","DB_LOGIN","DB_PASSWORD","DB_NAME","DB_REQUIRED",
	"DATE_FORMAT","PROTOCOL","MASTERHOST",
	"UPLOAD_FILES_PATH","CONTENT_URL","PHP_HIDE_ERRORS",
	"DEBUG","DEBUG_LOG","SITE_CLOSED","SHOW_ADMIN_MENU",
	"PHP_LOCALE","PHP_TIMEZONE","DATABATE_ENCODING",
	"FORSE_TRAILING_SLASH","SUBDOMAIN_LANGUAGES","REP",
	"USER_HASH_PASSWORD","USER_IGNORE_PRIVILEGES",
);


$configList = array();
foreach ($configListNames as $name) {
	$value = constant($name);
	if (is_bool($value)) {
		$value = $value ? 1 : 0;
	}
	$configList[$name] = $value;
}



if (!empty($_POST["save"])) {
	
	// write config.php
	
	$configPHP = "<?php \n";
	
	foreach ($configListNames as $name) {
		$valueCurrent = constant($name);
		
		if (array_key_exists("config_".$name, $_REQUEST)) {
			$value = $_REQUEST["config_".$name];
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
	
	if (is_writable(ABS."/config.php")) {
		file_put_contents(ABS."/config.php", $configPHP);
		
		MSV_MessageOK("".ABS."/config.php updated");
	} else {
		
		MSV_MessageError("Can't write to ".ABS."/config.php");
	}
}


MSV_assignData("admin_config_list", $configList);