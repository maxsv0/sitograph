<?php
/*

Functions list

*********** User ********** 
- MSV_Include($filePath) 


======= System functons ========

- MSV_Start()
	+ MSV_LoadSiteSettings();
	+ MSV_LoadSiteStructure();
	+ MSV_LoadPageMenu();
	
- MSV_Load()
	+ MSV_LoadPageNavigation();
	+ MSV_LoadPageDocument();
	
- MSV_Output()

- MSV_IncludeCSS($cssCode)	 => MSV_Include
- MSV_IncludeJS($jsCode)	 => MSV_Include
- MSV_IncludeHTML($htmlCode) => MSV_Include

- MSV_Document_add($name = "", $text = "", $ext_link = "", $lang = LANG) 
- MSV_Structure_add($lang, $url, $name = "", $template = "", $page_template = "", $sitemap = "", $menu = "", $menu_order = 0, $access, $parent_url = "") {
- MSV_MailTemplate_add($name = "", $subject = "", $text = "", $header = "", $lang = LANG) {

- MSV_PasswordGenerate($length = 12) returns string
- MSV_GetIP() {
- MSV_SitemapGenegate
- MSV_EmailTemplate($template, $mailTo, $data = array(), $message = true, $lang = LANG) 
- MSV_Email($to = "", $subject = "", $body = "", $header = "") {
- MSV_EmailDefault($to = "", $subject = "", $body = "", $header = "") 

- MSV_HighlightText($s, $text, $c) {



*/



function MSV_Start() {
	MSV_Log("Website: Start");
	
	MSV_LoadSiteSettings();
	MSV_LoadSiteStructure();
	MSV_LoadPageMenu();
	
	$theme_use_jquery = MSV_getConfig("theme_use_jquery");
	if ($theme_use_jquery > 0) {
		MSV_Include("/content/js/jquery.min.js");
	}
	
	$theme_use_bootstrap = MSV_getConfig("theme_use_bootstrap");
	if ($theme_use_bootstrap > 0) {
		MSV_Include("/content/css/bootstrap.min.css");
		MSV_Include("/content/js/bootstrap.min.js");
	}

	$theme_css_path = MSV_getConfig("theme_css_path");
	if (!empty($theme_css_path)) {
		MSV_Include($theme_css_path);
	}
	
	$theme_js_path = MSV_getConfig("theme_js_path");
	if (!empty($theme_js_path)) {
		MSV_Include($theme_js_path);
	}
	
	$message_ok = MSV_getConfig("message_ok");
	if (!empty($message_ok)) {
		MSV_MessageOK($message_ok);
	}
	$message_error = MSV_getConfig("message_error");
	if (!empty($message_error)) {
		MSV_MessageError($message_error);
	}

}


function MSV_Load() {
	$website = MSV_get("website");
	
	MSV_Log("Website: Load");
	
	
	$website->load();
	
	MSV_LoadPageNavigation();
	MSV_LoadPageDocument();
	
	$includeHead = MSV_getConfig("include_html_head");
	$website->includeHead[] = $includeHead;
	
	// TODO: add more html part to config
}


function MSV_Output404() {
	$website = MSV_get("website");

    $website = MSV_get("website");

    $website->log("Page not found, loading 404 template");
    $website->loadPage("/404/");

    // reload page document
    MSV_LoadPageDocument();

    // output page 404 if exist
    if (!empty($website->page)) {
        header("HTTP/1.0 404 Not Found");
        $website->outputPage();
    }

	$website->outputNotFound();
}


function MSV_Output() {
	$website = MSV_get("website");
	
	MSV_Log("Website: Output");
	
	if ($website->requestUrl === "/admin/") {
		$admin_module_setup = MSV_outputAdminModuleSetup();
		MSV_assignData("admin_module_setup", $admin_module_setup);
	}

		
	if (defined("SHOW_ADMIN_MENU") && SHOW_ADMIN_MENU > 0) {
		if ($website->requestUrl !== "/admin/" && $website->checkAccess("admin", $website->user["access"])) {
			$admin_menu = MSV_outputAdminMenu();
			
			$htmlFooter = MSV_getConfig("htmlFooter");
			$htmlFooter .= $admin_menu;
			MSV_setConfig("htmlFooter", $htmlFooter);
		}
	}

	
	$website->outputPage();
}



function MSV_IncludeCSS($cssCode) {
	$website = MSV_get("website");
	
	//TODO check $cssCode
	
	$website->includeCSSCode .= "\n".$cssCode;
}

function MSV_IncludeCSSFile($filePath, $url = "") {
	$website = MSV_get("website");
	
	//TODO check $filePath
	
	if (!empty($url)) {
		if (strpos($website->requestUrl, $url) !== 0) {
			return false;
		}
	}
	
	$website->includeCSS[] = $filePath;
	
	return true;
}

function MSV_IncludeJSFile($filePath, $url = "") {
	$website = MSV_get("website");
	
	//TODO check $filePath
	
	if (!empty($url)) {
		if (strpos($website->requestUrl, $url) !== 0) {
			return false;
		}
	}
	
	$website->includeJS[] = $filePath;
	
	return true;
}

function MSV_IncludeJS($jsCode) {
	$website = MSV_get("website");
	
	//TODO check $jsCode
	
	$website->includeJSCode .= "\n".$jsCode;
}

function MSV_IncludeHTML($htmlCode) {
	$website = MSV_get("website");
	
	//TODO check $htmlCode
	
	$website->includeHTMLCode .= "\n".$htmlCode;
}

function MSV_Include($filePath, $url = "") {
	$website = MSV_get("website");
	
	//TODO check $filePath
	//TODO check for dublicate
	
	if (!empty($url)) {
		if ($url !== $website->requestUrl) {
			return false;
		}
	}
	
	if (strpos($filePath, "http") === 0) {
		//  remove files
		
		$type = substr($filePath, strrchr($filePath, ".")+1);
	} else {
		//  local files
		$type = pathinfo($filePath, PATHINFO_EXTENSION);
	}
	
	
	switch ($type) {
		case "css":
			$website->includeCSS[] = $filePath;
			break;
		case "js":
			$website->includeJS[] = $filePath;
			break;
	
		default:
			break;
	}
	
	return true;
}


function MSV_Log($logText = "", $type = "warning") {
	$website = MSV_get("website");
	
	$website->log($logText, $type);
	
	return true;
}

function MSV_MessageOK($messageText = "") {
	if (empty($messageText)) return false;
	
	$website = MSV_get("website");
	$website->messages["success"][] = $messageText;
	
	return true;
}
function MSV_MessageError($messageText = "") {
	if (empty($messageText)) return false;
	
	$website = MSV_get("website");
	$website->messages["error"][] = $messageText;
	
	return true;
}
function MSV_HasMessageError() {
	$website = MSV_get("website");
	
	if (!empty($website->messages["error"])) {
		return true;
	}
	
	return false;
}

function MSV_Error($errorText = "") {
	$website = MSV_get("website");
	
	//TODO: make log
	
	$website->outputError($errorText);
	return true;
}

function MSV_LoadPageDocument() {
	MSV_Log("Website -> LoadPageDocument");
	
	$website = MSV_get("website");
	
	if (empty($website->page["page_document_id"])) {
		MSV_Log("page_document_id empty");
		return false;
	} else {
		MSV_Log("page_document_id -> ".$website->page["page_document_id"]);
	}
	
	$result = API_getDBItem(TABLE_DOCUMENTS, " `id` = '".(int)$website->page["page_document_id"]."'");

	$separator = "<hr class=\"next_block\">";
	$document = $result["data"];
	$documentText = $document["text"];
	$documentBlocks = array();
	if (strpos($documentText,$separator) !== false) {
		
		$documentBlocks = explode($separator, $documentText);
		
	} else {
		$documentBlocks[] = $documentText;
	}
	$document["text"] = $documentText;
	
	if (!$result["ok"]) {
		MSV_ERROR($result["msg"]);
	}
	$website->document = $document;
	$website->document_blocks = $documentBlocks;

	return true;
}

function MSV_LoadPageNavigation() {
	$page = MSV_get("website.page");
	$structure = MSV_get("website.structure");

	if ($page["url"] !== "/") {
		
		if ($page["parent_id"] == 0) {
		
			MSV_setNavigation($page["name"], $page["url"], true);
			
		} else {
			// TODO .. load parents
			
			MSV_setNavigation($page["name"], $page["url"], true);
		}
	}
	foreach ($structure as $item) {
		if ($item["url"] !== "/") {
			continue;
		}
		MSV_setNavigation($item["name"], $item["url"], true);
	}
}

function MSV_setNavigation($name, $url = "", $pos = false) {
	$website = MSV_get("website");
	
	// TODO : CHECK ... 
	
	$ar = array(
		"name" => $name,
		"url" => $url,
	);
	if ($pos) {
		array_unshift($website->navigation, $ar);
	} else {
		$website->navigation[] = $ar;
	}
	
}

function MSV_LoadPageMenu() {
	MSV_Log("Website -> LoadPageMenu");
	
	$result = API_getDBList(TABLE_MENU, "", "`order_id` asc");
	
	if (!$result["ok"]) {
		MSV_ERROR($result["msg"]);
	}
	$list = $result["data"];

	$menu = array();
	foreach ($list as $item) {
		$menuID = (string)$item["menu_id"];
		$menu[$menuID][] = $item;
	}
	
	foreach ($menu as $menuID => $item) {
		API_setMenu($menuID, $item);
	}
}

function MSV_LoadSiteSettings() {
	MSV_Log("Website -> LoadSiteSettings");
	$result = API_getDBList(TABLE_SETTINGS);
	
	if (!$result["ok"]) {
		MSV_ERROR($result["msg"]);
	}
	$list = $result["data"];
	foreach ($list as $item) {
		$param = (string)$item["param"];
		$value = (string)$item["value"];
		MSV_setConfig($param, $value);
	}
}

function MSV_setConfig($param, $value, $updateDB = false, $lang = LANG) {
	$website = MSV_get("website");
	
	// TODO : CHECK ... 
	if (array_key_exists($param, $website->config)) {
		$website->config[$param] = $value;
		
		if ($updateDB) {
			return API_updateDBItem(TABLE_SETTINGS, "value", "'".MSV_SQLEscape($value)."'", " `param` = '".$param."'");
		}
		
	} else {
		$website->config[$param] = $value;
		
		if ($updateDB) {
			$item = array(
				"published" => 1,
				"value" => $value,
				"param" => $param,
			);
			
			return API_itemAdd(TABLE_SETTINGS, $item, $lang);
		}
	}
	
	return true;
}

function MSV_getConfig($param) {
	$website = MSV_get("website");
	
	// TODO : CHECK ... 
	if (array_key_exists($param, $website->config)) {
		
		return $website->config[$param];
		
	} else {
		
		return false;
	}
}

function MSV_LoadSiteStructure() {
	MSV_Log("Website -> LoadSiteStructure");
	$result = API_getDBList(TABLE_STRUCTURE);
	
	if (!$result["ok"]) {
		MSV_ERROR($result["msg"]);
	}
	$list = $result["data"];
	foreach ($list as $item) {
		API_setStructure($item);
	}
	
}



function MSV_enableModule($module) {
	MSV_Log("===== enableModule $module");
	
	$website = MSV_get("website");
	
	// check $module if module is disabled
	
	$pathModuleDisabled = ABS_MODULE."/-".$module;
	$pathModuleEnabled = ABS_MODULE."/".$module;
	
	if (!file_exists($pathModuleDisabled)) return false;
	if (!is_dir($pathModuleDisabled)) return false;
	
	$pathModulePHP = $pathModuleDisabled."/".$module.".php";
	if (!file_exists($pathModulePHP)) return false;
	if (!is_readable($pathModulePHP)) return false;
	
	exec("mv ".escapeshellarg($pathModuleDisabled)." ".escapeshellarg($pathModuleEnabled));

	MSV_Log("===== enableModule OK");
	
	$website->outputRedirect("/admin/");
	
	return true;
}


function MSV_disableModule($module) {
	MSV_Log("Website -> disableModule $module");
	
	$website = MSV_get("website");
	
	// check if module is enabled
	
	$pathModuleDisabled = ABS_MODULE."/-".$module;
	$pathModuleEnabled = ABS_MODULE."/".$module;
	
	if (!file_exists($pathModuleEnabled)) return false;
	if (!is_dir($pathModuleEnabled)) return false;
	
	$pathModulePHP = $pathModuleEnabled."/".$module.".php";
	if (!file_exists($pathModulePHP)) return false;
	if (!is_readable($pathModulePHP)) return false;
	
	exec("mv ".escapeshellarg($pathModuleEnabled)." ".escapeshellarg($pathModuleDisabled));
	
	MSV_Log("===== disableModule OK");
	
	$website->outputRedirect("/admin/");
	
	return true;
}

function MSV_removeModule($module) {
	// TODO: DO
	return false;
	
	MSV_Log("***** removeModule $module");
	// remove only disabled.
	
	$website = MSV_get("website");
	
	// remove tables
	$obj = $website->{$module};
	
	if ($obj->enabled) {
		$website->messages["error"][] = _t("msg.error_remove_active");
		return false;
	}
	
	
	if (!$obj->started) {
		$website->runModule($module);
	}
	if (!empty($obj->tables)) {
		$tableList = $obj->tables;
		
		if (!empty($tableList)) {
			foreach ($tableList as $tableName => $tableInfo) {
				API_removeTable($tableName);
			}
		}
	}	
	if (!empty($obj->files)) {
		$filesList = $obj->files;
		
		if (!empty($filesList)) {
			foreach ($filesList as $fileInfo) {
				unlink($fileInfo["abs_path"]);
			}
		}
	}	
	$website->messages["success"][] = "<b>$module</b> "._t("msg.removed").".";
	
	MSV_Log("Website -> removeModule OK");
	return true;
}

function MSV_listModules() {
	MSV_Log("Website -> listModules");
	
	$cont = file_get_contents(REP);
	
	if (!$cont) {
		return false;
	}
	
	$result = json_decode($cont, true);

	if ($result["ok"]) {
		$mosulesList = $result["data"];
		uasort($mosulesList, "cmp_modules_list");
		
		MSV_Log("Website -> listModules OK");
		
		return $mosulesList;
	} else {
		MSV_ERROR($result["msg"]);
	}
	
	return false;
}

function cmp_modules_list($a, $b) {
    return strcmp($a["title"], $b["title"]);
}

function MSV_installModule($module, $redirect = true) {
	MSV_Log("*****  installModule -> $module");
	
	$website = MSV_get("website");
	
	// TODO add info, check
	$list = MSV_listModules();
	if (empty($list)) {
		MSV_MessageError("installModule -> $module "._t("msg.no_repository"));
		return false;
	}
	
	$moduleInfo = $list[$module];
	if (empty($moduleInfo)) {
		MSV_MessageError("installModule -> $module "._t("msg.repository_not_found"));
		return false;
	}
	
	// download zip
	$moduleUrl = $moduleInfo["download_url"];
	$moduleCont = file_get_contents($moduleUrl);
	
	$zipFile = tmpfile();
	$metaDatas = stream_get_meta_data($zipFile);
	$tmpFilename = $metaDatas['uri'];
	file_put_contents($tmpFilename, $moduleCont);
	
	// create temp dir
	$tempDir = tempnam(sys_get_temp_dir(),'');
	$tempDir = $tempDir."dir";
	mkdir($tempDir);
	
//	$zipArchive = new PclZip($tmpFilename);
//	if (!$zipArchive->extract(PCLZIP_OPT_PATH, $tempDir) == 0) {
//		MSV_Error("installModule -> "._t("msg.cant_open_zip"));
//	}

	// try to extract using ZipArchive lib
	// in case of fail, use shell_exec
	if (class_exists("ZipArchive")) {
		$zipArchive = new ZipArchive();
		if (!$zipArchive->open($tmpFilename)) {
			MSV_Error("installModule -> "._t("msg.cant_open_zip"));
			return false;
		}
		$zipArchive->extractTo($tempDir);
		$zipArchive->close();
	} else {
		shell_exec("unzip $tmpFilename -d $tempDir");
	}

	// TODO:
	// check if files are in $tempDir/..
	
	$moduleObj = MSV_get("website.".$module);
	if (!empty($moduleObj)) {
		
		// module exist, overwrite
		$fileList = $moduleObj->files;
	} else {
		// module first install
		
		$fileList = $moduleInfo["files"];
	}

	if (empty($fileList)) {
		MSV_Error("$module: File list empty");
	}
	
	// copy files according to config
	foreach ($fileList as $fileInfo) {
		$filePath = $tempDir."/".$fileInfo["dir"]."/".$fileInfo["path"];
		
		$fileCopyPath = $fileInfo["abs_path"];
		if (empty($fileCopyPath)) {
			if ($fileInfo["dir"] === "abs") {
				$fileCopyPath = ABS."/".$fileInfo["path"];
			} elseif ($fileInfo["dir"] === "include") {
				$fileCopyPath = ABS_INCLUDE."/".$fileInfo["path"];
			} elseif ($fileInfo["dir"] === "module") {
				$fileCopyPath = ABS_MODULE."/".$fileInfo["path"];
			} elseif ($fileInfo["dir"] === "template") {
				$fileCopyPath = ABS_TEMPLATE."/".$fileInfo["path"];
			} elseif ($fileInfo["dir"] === "content") {
				$fileCopyPath = UPLOAD_FILES_PATH."/".$fileInfo["path"];
			}
		}
		if (empty($fileCopyPath)) {
			MSV_Error("Can't copy file $filePath. Destination path is empty.");
		}
		
		if (!file_exists($filePath)) {
			MSV_Error("File not exist $filePath");
		}
		
		$pathinfo = pathinfo($fileCopyPath);
		
		// create dirs in path
		if (!file_exists($pathinfo['dirname'])) {
			mkdir($pathinfo['dirname'], 0777, true);
		}
		
		chmod($filePath, 0664);
		
		// copy file
		$r = copy($filePath, $fileCopyPath);
		
		MSV_Log("MSV copy: $filePath -> $fileCopyPath -> ".($r ? 'true' : 'false'));
	}
	
	
	if ($redirect) {
		MSV_Log("installModule -> redirect");
		$website->outputRedirect("/admin/?install_hook=".$module);
	}
	
	return true;
}

function MSV_reinstallModule($module, $redirect = true) {
	MSV_Log("***** reinstallModule");
	
	// TODO: check, reinstall ckeck??
	MSV_installModule($module, $redirect);

	return true;
}





function MSV_DataFormat($table, $dataRow) {
	//TODO ... 
	
	$tablesList = MSV_get("website.tables");
	
	if (!array_key_exists($table, $tablesList)) {
		return $dataRow;
	}
	
	$infoTable = $tablesList[$table];
	
	foreach ($infoTable["fields"] as $field) {
		$value = $dataRow[$field["name"]];
		
		switch ($field["type"]) {
			case "pic":
				if (!empty($value)) {
					if (strpos($value, "http") !== 0) {
						$dataRow[$field["name"]] = CONTENT_URL."/".$value;
					}
				}
				
			break;
			case "array":
			case "multiselect":
				$dataRow[$field["name"]] = unserialize($value);
			break;
			case "date":
			case "datetime":
				if (!empty($value) && $value !== "0000-00-00 00:00:00") {
					$dataRow[$field["name"]] = date(DATE_FORMAT, strtotime($value));
				}
			break;
		
			default:
				break;
		}
	}
	
	
	return $dataRow;
}

function MSV_getTableConfig($table) {
	//TODO  add some check
	
	$tablesList = MSV_get("website.tables");
	
	if (!array_key_exists($table, $tablesList)) {
		return false;
	}
	
	$infoTable = $tablesList[$table];
	
	return $infoTable;
}


function MSV_SQLRow($sqlQuery) {
		
	$row = mysqli_fetch_assoc($sqlQuery);
	
	return $row;
}


function MSV_SQLEscape($string) {

	$website = MSV_get("website");

	$string = (string)$string;
	
	$stringEscaped = mysqli_real_escape_string($website->config["db"], $string);
	
	return $stringEscaped;
}


function MSV_storeFile($url, $type = "jpg", $name = "", $table = "", $field = "") {
	
	// path example:
	// content/table/year/month/hash.jpg
	// copy file
	
	if (empty($url)) {
		return false;
	}
	
	$cont = file_get_contents($url);
	if (!$cont) {
		return false;
	}
	
	$hash = uniqid();
	
	if (!empty($name)) {
		if (substr($name, -strlen($type)-1) == ".".$type) {
			$name = substr($name, 0, -strlen($type)-1);
		}
		$fileName = $name."-".$hash.".".$type;
	} elseif (!empty($field)) {
		$fileName = $hash."-".$field.".".$type;
	} else {
		$fileName = $hash.".".$type;
	}
	
	// create folders in path
	if (!empty($table)) {
		$dirPath = UPLOAD_FILES_PATH."/".$table;
		
		if (!file_exists($dirPath)) {
			$r = mkdir($dirPath);
			if (!$r) {
				return -1;
			}
		}
		
		$year = date("Y");
		$month = date("m");
		
		
		$dirPath = $dirPath."/".$year;
		if (!file_exists($dirPath)) {
			$r = mkdir($dirPath);
			if (!$r) {
				return -2;
			}
		}
		
		$dirPath = $dirPath."/".$month;
		if (!file_exists($dirPath)) {
			$r = mkdir($dirPath);
			if (!$r) {
				return -3;
			}
		}
		
		$fileUrl = $table."/".$year."/".$month."/".$fileName;
	} else {
		$dirPath = UPLOAD_FILES_PATH;
		
		$fileUrl = $fileName;
	}
	
	$filePath = $dirPath."/".$fileName;
	
	$r = file_put_contents($filePath, $cont);
	if ($r) {
		return $fileUrl;
	}
	
	return -10;
}



function MSV_storePic($url, $type = "jpg", $name = "", $table = "", $field = "") {
	
	// store original file
	$fileResult = MSV_storeFile($url, $type, $name, $table, $field);
	
	if (is_numeric($fileResult)) {
		// result is error
		return $fileResult;
	}
	
	$fileUrl = HOME_URL.CONTENT_URL."/".$fileResult;
	$filePath = UPLOAD_FILES_PATH."/".$fileResult;
	
	// copy file
	$cont = file_get_contents($fileUrl);
	if ($cont) {
		
		if (!empty($field) && !empty($table)) {
			$tablesList = MSV_get("website.tables");
			$infoTable = $tablesList[$table];

			$infoField = $infoTable["fields"][$field];
			
			if (!empty($infoField["max-width"]) || !empty($infoField["max-height"])) { 
				// check img size, resize if need
				
				// create imgage using GD
				$img = imagecreatefromstring($cont);
				
				$height = imagesy($img);
				$width = imagesx($img);
				
				if (!empty($infoField["max-width"]) && $width > $infoField["max-width"]) {
					$widthNew = $infoField["max-width"];
					$heightNew = $height/$width*$widthNew;
					
					$imgNew = imagecreatetruecolor($widthNew, $heightNew);

                    // save alpha channel
                    imagesavealpha($imgNew, true);
                    imagealphablending($imgNew, false);

                    if ($type === "jpg") {
                        $bgColor = imagecolorallocatealpha($imgNew, 255, 255, 255, 0);
                    } else {
                        $bgColor = imagecolorallocatealpha($imgNew, 255, 255, 255, 127);
                    }
                    imagefill($imgNew, 0, 0, $bgColor);

                    // copy image
                    imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $widthNew, $heightNew, $width, $height);
					$img = $imgNew;
					
					
					switch ($type) {
						case "png":
							imagepng($img, $filePath);
						break;
						case "gif":
							imagegif($img, $filePath);
						break;
						case "jpg":
							imagejpeg($img, $filePath, 90);
						break;
						default:
							imagejpeg($img, $filePath, 90);
							break;
					}
					
					return $fileUrl;
				} else {
					
					// do not resize
					// do not change original file
					
				}
				
			}
		}
		
		return $fileResult;
	}
	
	return -10;
}

function MSV_get($param = "website") {

	global $website;
	if (empty($website)) {
		// TODO: ???
		die(".");
	}
	
	$returnObj = null;
	
	$arPath = explode(".", $param);
	if (count($arPath) > 1) {
		
		$item = $arPath[1];
		
		$returnObj = $website->{$item};
	} else {
		$returnObj = $website;
	}
	
	return $returnObj;
}


function MSV_assignData($dataName, $dataValue) {
	$website = MSV_get("website");
	if (!$website) return false;
	
	$website->config[$dataName] = $dataValue;
	return true;
}

// TODO:

// 

function MSV_checkFiles() {
	$website = MSV_get("website");
	
	
	$di = new RecursiveDirectoryIterator(ABS, RecursiveDirectoryIterator::SKIP_DOTS);
	$it = new RecursiveIteratorIterator($di);
	
	$fileModuleList = array();
	foreach ($website->modules as $module) {
		$files = $website->{$module}->files;
		
		foreach ($files as $file) {
			$fileModuleList[$file["abs_path"]] = $module;
		}
	}
	
	$fileList = array();
	foreach($it as $file) {
		$file = (string)$file;
	   if (strpos($file, "/include/custom/") !== false) continue;
	   if (strpos($file, ".git") !== false) continue;
	   $fileList[] = $file;
	}
	
	foreach ($fileList as $file) {
		echo "$file ";
		if (array_key_exists($file, $fileModuleList)) {
			echo "<span style='color:green;'>".$fileModuleList[$file]." - ok</span>";
		} else {
			echo "<span style='color:red;'>NOT FOUND</span>";
		}
		echo "<br>";
	}
}



function MSV_assignTableData($table, $prefix = "") {
	$tableInfo = MSV_getTableConfig($table);
	
	if (empty($tableInfo)) {
		return false;
	}
	
	foreach ($tableInfo["fields"] as $item) {
		if (!array_key_exists($prefix.$item["name"], $_REQUEST)) {
			MSV_assignData($prefix.$item["name"], $_REQUEST[$prefix.$item["name"]]);
		}
	}
	
	return true;
}


function MSV_proccessUpdateTable($table, $prefix = "") {
	$info = MSV_getTableConfig($table);
	
	if (empty($info)) {
		return false;
	}
	
	$itemNew = array();
	
	foreach ($info["fields"] as $item) {
		
		
		// skip fields that where not changed
		if (!array_key_exists($prefix.$item["name"], $_REQUEST)) {
			continue;
		}
		
		
		$value = $_REQUEST[$prefix.$item["name"]];
		switch ($item["type"]) {
			case "id":
				$itemNew[$item["name"]] = (int)$value;
			break;
			case "published":
			case "deleted":
			case "bool":
				if (empty($value)) {
					$itemNew[$item["name"]] = 0;
				} else {
					$itemNew[$item["name"]] = 1;
				}
			break;
			case "lang":
				// TODO: check lang
				$itemNew[$item["name"]] = $value;
			break;
			case "author":
				if (empty($itemNew["author"]) && !empty($_SESSION["user_email"])) {
					$itemNew["author"] = $_SESSION["user_email"];
				}
			break;

			case "pic":
			case "file":
				if (!empty($value)) {
					if (strpos($value, CONTENT_URL) === 0) {
						$value = substr($value, strlen(CONTENT_URL)+1);
					}
					$itemNew[$item["name"]] = $value;
				} else {
					$itemNew[$item["name"]] = "";
				}
			break;
			
			case "updated":
				$itemNew[$item["name"]] = date("Y-m-d H:i:s");
			break;
			case "array":
			case "multiselect":
				$itemNew[$item["name"]] = serialize($value);
			break;
			case "date":
				$dt = strtotime($value);
				$itemNew[$item["name"]] = date("Y-m-d H:i:s", $dt);
			break;
			
			case "str":
			case "doc":
			default:
					$itemNew[$item["name"]] = $value;
				break;
		}
	}

	$result = API_updateDBItemRow($table, $itemNew);
	return $result;
}


function MSV_redirect($url) {
	$website = MSV_get("website");

	// check lang URL
    if (!empty($website->langUrl)) {

        // only in case of local redirect
        if (substr($url, 0, 1) === '/' && strpos($url, $website->langUrl) !== 0) {
            $url = $website->langUrl.$url;
        }

    }
    
	$website->outputRedirect($url);
}


function MSV_outputAdminMenu() {
	$W = MSV_get("website");
	
    $strOut  .='<table width="100%" cellpadding="0" cellspacing="0" class="admin_panel">';
    $strOut  .='<tbody><tr><td width="50%" align="right" style="padding-right:10px;">';
    $strOut  .='<p>'._t("title.back_to_admin").'</p></td>';
    $strOut  .='<td align="left">';
    $strOut  .='<a href="/admin/">';
    $strOut  .='<div class="admin_pic">&nbsp;</div>';
    $strOut  .='<div class="admin_title">'._t("btn.back_to_admin").'</div>';
    $strOut  .='</a>';
    $strOut  .='</td></tr></tbody></table>';
    $strOut  .='<style>';
    $strOut  .='body {padding-top:30px;}';
    $strOut  .='</style>';
	
	
	
//	$strOut  = "";
//	$strOut .= "<div style='position:fixed;opacity:0.5;bottom:0;left:0;width:150px;background:rgba(0,0,0,0.8);color:#fff;padding:20px 15px;'>";
//	$strOut .= "<p><a href='".$W->langUrl."/admin/' style='color:#fff;'>"._t("btn.back_to_admin")."</a></p><hr>";
//	$strOut .= "<h4>".$W->page["name"]."</h4>";
//	$strOut .= "<h5>url: ".$W->page["url"]."</h5>";
//	$strOut .= "<p><a href='".$W->langUrl."/admin/?section=structure&table=structure&edit=".$W->page["id"]."' style='color:#fff;'>"._t("btn.edit_settings")."</a></p>";
//	if ($W->page["page_document_id"]) {
//		$strOut .= "<p><a href='".$W->langUrl."/admin/?section=documents&table=documents&edit=".$W->page["page_document_id"]."#document' style='color:#fff;'>"._t("btn.document_edit")."</a></p>";
//	} else {		
//		$strOut .= "<p><a href='".$W->langUrl."/admin/?section=structure&document_create=".$W->page["id"]."' style='color:#fff;'>"._t("btn.document_create")."</a></p>";
//	}
//	$strOut .= "<p><a href='".$W->langUrl."/admin/?section=structure&table=structure&edit=".$W->page["id"]."#seo' style='color:#fff;'>"._t("btn.edit_seo")."</a></p>";
//	$strOut .= "</div>";

	return $strOut;
}


function MSV_outputAdminModuleSetup() {
	$website = MSV_get("website");
	$list = $website->modules;
	
	$strOut  = "";
	$strOut .= "<div class='well'>";
	$strOut .= "<p>";
	
	$website = MSV_get("website");
	
	foreach ($list as $module) {
		$obj = $website->{$module};
		if ($obj->enabled) {
			$strOut .= "<a href='/admin/?section=module_settings&module=".$obj->name."' class='btn btn-primary'>$module</a>";
		} else {
			$strOut .= "<a href='/admin/?section=module_settings&module=".$module."' class='btn btn-default'>$module</a>";
		}
		$strOut .= "&nbsp; &nbsp;";
	}
	$strOut .= "</p>";
	

	$strOut .= "<p>";
	$strOut .= "<a href='/admin/?section=module_settings&module_install' class='btn btn-danger'>install new</a> &nbsp; &nbsp;";
	$strOut .= "<a href='/admin/?section=module_settings&module_update_all' class='btn btn-danger'>update all</a> &nbsp; &nbsp;";		
	$strOut .= "</p>";
	
	$module = $_GET["module"];
	if (!empty($module)) {
		$strOut .= "<p>";
		$strOut .= "Repository: ";
		$headers = get_headers(REP);
	
		if(strpos($headers[0],'200')===false) {
			$strOut .= "<span class='text-danger'>offline</span>";
		} else {
			$strOut .= "<span class='text-success'>online</span>";
		}
		$strOut .= "</p>";
	
	
		$obj = $website->{$module};
		$oVersion = (float)$obj->version;

		$strOut .= "<h3>".$obj->title." <small>".$obj->description."</small></h3>";
		
		$files = $obj->files;
		if (!empty($files)) {
			foreach ($files as $file) {
				$strOut .= "<div>";
				if (is_writable($file["abs_path"])) {
					$strOut .= "<span class='text-success'>";
				} else {
					$strOut .= "<span class='text-danger'>NOT Writable: ";
				}
				if ($file["dir"] === "content" || $file["dir"] === "abs") {
					$strOut .= " <a href='".$file["url"]."'>".$file["local_path"]."</a>";
				} else {
					$strOut .= " ".$file["local_path"]."";
				}
				$strOut .= "</span>&nbsp;&nbsp;";
				
				if (file_exists($file["abs_path"])) {
					$info = stat($file["abs_path"]);
					$strOut .= " <small>".formatSizeUnits($info["size"])."</small>";
				} else {
					$strOut .= " - <b>NOT FOUND</b>";
				}
				
				$strOut .= "</div>";
			}
			$strOut .= "<p><b>".count($files)." files</b></p>";
		}
		if ($module !== "api" && $module !== "core") {
			$strOut .= "<p>";
			
			$strOut .= "<a href='/admin/?module_reinstall=".$obj->name."' class='btn btn-danger btn-sm' onclick=\"if(!confirm('Are you sure? Current module files will be overwritten.')) return false;\">reinstall</a> ";
				
			if ($obj->enabled) {
				$strOut .= "<a href='/admin/?module_disable=".$obj->name."' class='btn btn-danger btn-sm'>disable module</a>";
			} else {
				$strOut .= "<a href='/admin/?module_enable=".$obj->name."' class='btn btn-danger btn-sm'>enable module</a>";
			}
			$strOut .= "&nbsp; &nbsp; ";
			$strOut .= "<a href='/admin/?module_remove=".$obj->name."' class='btn btn-danger btn-sm' onclick=\"if(!confirm('ALL DATA WILL BE LOST! Are you sure?')) return false;\">remove module</a> &nbsp; &nbsp;";
			$strOut .= "</p>";
		}
		
		$tables = $obj->tables;
		if (!empty($tables)) {
			$strOut .= "<div>";
			$strOut .= "<h4>".$module." tables</h4>";
			foreach ($tables as $table) {
				$strOut .= "<p>";
				$strOut .= "".$table["name"]." ";
				$strOut .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$table["name"]."&table_action=remove' class='btn btn-danger btn-xs'>remove table</a> ";
				$strOut .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$table["name"]."&table_action=truncate' class='btn btn-danger btn-xs'>truncate table</a> ";
				$strOut .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$table["name"]."&table_action=create' class='btn btn-primary btn-xs'>create table</a> ";
				$strOut .= "</p>";
			}
			$strOut .= "</div>";
		}
	}
	if (isset($_GET["module_install"])) {
		$listRep = MSV_listModules();
		foreach ($listRep as $module => $moduleInfo) {
			$obj = $website->{$moduleInfo["name"]};
			$strOut .= "<p>";
			$name = $moduleInfo["name"];
			$title = $moduleInfo["title"];
			if (empty($title)) {
				$title = $moduleInfo["name"];
			}
			$strOut .= "<a class='btn' data-toggle='collapse' data-target='#module-".$name."'>".$title."</a> ";
			
			if (!empty($obj)) {
				$strOut .= "&nbsp;&nbsp;<b>installed</b> ";
			}
			
			$strOut .= "<div class='collapse' id='module-".$name."'>";
			$strOut .= "<p><small>v.".$moduleInfo["version"].", ".$moduleInfo["date"].", downloads: ".$moduleInfo["downloads"]."</small></p>";

			if (!empty($moduleInfo["description"])) {
				$strOut .= "<p>".$moduleInfo["description"]."</p>";
			}
			
			$strOut .= "<p>";
			$arDep = explode(",", $moduleInfo["dependency"]);
			if (!empty($arDep)) {
				$strOut .= "Dependency: ";
				
				$meetDep = true;
				foreach ($arDep as $depModuleName) {
					if (in_array($depModuleName, $list)) {
						$strOut .= "<span class='text-success'>".$depModuleName."</span>";
					} else {
						$strOut .= "<span class='text-danger'>".$depModuleName."</span>";
						$meetDep = false;
					}
					$strOut .= ", ";
				}
				$strOut = substr($strOut, 0, -2);
			}
			$strOut .= "</p>";
			
			
			
			
			
			$strOut .= "<p>";
			$strOut .= "<a href='".$moduleInfo["download_url"]."' class='btn btn-primary btn-xs'>".$title.".zip</a> ";
			
			if (!empty($obj)) {
				$strOut .= "<a href='/admin/?module_reinstall=".$moduleInfo["name"]."' class='btn btn-danger btn-xs' onclick=\"if(!confirm('Are you sure? Current module files will be overwritten.')) return false;\">reinstall</a> ";
				
				$mVersion = (float)$moduleInfo["version"];
				$oVersion = (float)$obj->version;
				
				if ($mVersion > $oVersion) {
					$strOut .= "<a href='/admin/?module_reinstall=".$moduleInfo["name"]."' class='btn btn-danger btn-xs'>update</a> ";
				}
			} else {
				if (!$meetDep) {
					$strOut .= "<a href='/admin/?module_install=".$moduleInfo["name"]."' class='btn btn-primary btn-xs' onclick=\"if(!confirm('Installing module without dependencies can cause system error.')) return false;\">install</a> ";
					$strOut .= "<span class='text-danger'>Dependencies not met<span> ";
				} else {
					$strOut .= "<a href='/admin/?module_install=".$moduleInfo["name"]."' class='btn btn-primary btn-xs'>install</a> ";
				}
			}
			
			
			$strOut .= "</p>";
			
			
			$strOut .= "&nbsp; &nbsp;";
			$strOut .= "</div> ";
			
			
			
			
			
			$strOut .= "</p>";
		}
	}
	$strOut .= '</div>';
	
	return $strOut;
}


function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}


function _t($textID) {
	// return language constant for current language
	
	$website = MSV_get("website");

	if (array_key_exists($textID, $website->locales)) {
		$retStr = $website->locales[$textID];
		
		// replace pattern:
		// {CONSTANT} into values
		// 
		
		$retStr = preg_replace_callback(
		    '~\{(\w+?)\}~sU',
		    create_function('$t','
		        return constant($t[1]);
		    '),
		    $retStr);
		
		return $retStr;
	} else {
		return $textID;
	}
}




// ********** User Functions ********


function MSV_Structure_add($lang, $url, $name = "", $template = "", $page_template = "", $sitemap = "", $menu = "", $menu_order = 0, $access, $parent_url = "") {
	
	
	// run recursively and exit
	if ($lang === "all") {
		
		$website = MSV_get("website");

		foreach ($website->languages as $langID) {
			MSV_Structure_add($langID, $url, $name, $template, $page_template, $sitemap, $menu, $menu_order, $access, $parent_url);
		}
		
		return true;
	}
	
	$parent_id = 0;
	if (!empty($parent_url)) {
		$resultParent = API_getDBItem(TABLE_STRUCTURE, "`url` = '".MSV_SQLEscape($parent_url)."'");
		if ($resultParent["ok"]) {
			$parent_id = $resultParent["data"]["id"];
		}
	}
	
	
	$item = array(
		"published" => 1,
		"url" => $url,
		"parent_id" => $parent_id,
		"name" => $name,
		"template" => $template,
		"page_template" => $page_template,
		"sitemap" => $sitemap,
		"access" => $access,
	);
	
	$result = API_itemAdd(TABLE_STRUCTURE, $item, $lang);

	if ($result["ok"]) {
		// get net structure id 
		$structure_id = $result["insert_id"];
		
		// add seo
		SEO_add($url, $name, '', '', $sitemap, $lang);
		
		// add docuemnt
		$resultDocument = MSV_Document_add($name, "", "", $lang);
		
		// update structure=>set document
		if ($resultDocument["ok"]) {
			API_updateDBItem(TABLE_STRUCTURE, "page_document_id", $resultDocument["insert_id"], " id = '".$structure_id."'");
		}
		
		if (!empty($menu)) {
			$item = array(
				"published" => 1,
				"url" => $url,
				"name" => $name,
				"menu_id" => $menu,
				"structure_id" => $structure_id,
				"order_id" => $menu_order,
			);
			API_itemAdd(TABLE_MENU, $item, $lang);
		}
	}
	
	return $result;
}


function MSV_Document_add($name = "", $text = "", $ext_link = "", $lang = LANG) {
	
	$item = array(
		"published" => 1,
		"name" => $name,
		"text" => $text,
		"ext_link" => $ext_link,
	);
	
	$result = API_itemAdd(TABLE_DOCUMENTS, $item, $lang);

	return $result;
}


function MSV_MailTemplate_add($name = "", $subject = "", $text = "", $header = "", $lang = LANG) {
	
	$item = array(
		"published" => 1,
		"name" => $name,
		"subject" => $subject,
		"text" => $text,
		"header" => $header,
	);
	
	$result = API_itemAdd(TABLE_MAIL_TEMPLATES, $item, $lang);

	return $result;
}


function MSV_EmailDefault($to = "", $subject = "", $body = "", $header = "") {
	
	$emailFrom = MSV_getConfig("email_from");
	$emailFromName = MSV_getConfig("email_fromname");
	if (!empty($emailFromName)) {
		$emailFromHeader = $emailFromName." <".$emailFrom.">";
	} else {
		$emailFromHeader = $emailFrom;
	}
	$headers = "From: ".$emailFromHeader."\r\nContent-type: text/html; charset=\"UTF-8\" \r\n";
	if (!empty($header)) {
		$headers .= $header;
	}
	
	return mail($to, $subject, $body, $headers);
}

function MSV_Email($to = "", $subject = "", $body = "", $header = "") {
	
	$mailer = MSV_getConfig("mailer");

	return call_user_func_array($mailer, array($to, $subject, $body, $header));
}

function MSV_EmailTemplate($template, $mailTo, $data = array(), $message = true, $lang = LANG) {
	
	// get template
	$resultMail = API_getDBItem(TABLE_MAIL_TEMPLATES, " `name` = '".MSV_SQLEscape($template)."'", $lang);

	if ($resultMail["ok"]) {
		$mailSubject = $resultMail["data"]["subject"];
		$mailBody = $resultMail["data"]["text"];
		
		MSV_setConfig("dataTemplate", $data);
		
		// replace pattern:
		// {email} into $data["email"]

		$mailBody = preg_replace_callback(
		    '~\{(\w+?)\}~sU',
		    create_function('$t','
		   	 $r = MSV_getConfig("dataTemplate");
		     return $r[$t[1]];
		    '),
		    $mailBody);

		$mailSubject = preg_replace_callback(
		    '~\{(\w+?)\}~sU',
		    create_function('$t','
		   	 $r = MSV_getConfig("dataTemplate");
		     return $r[$t[1]];
		    '),
		    $mailSubject);
		    
		    
		// add header HTML to a body
		if (!empty($resultMail["data"]["header"])) {
			$mailBody = $resultMail["data"]["header"].$mailBody;
		}
		 
		$r = MSV_Email($mailTo, $mailSubject, $mailBody);
		
		if ($r) {
			if ($message) {
				MSV_MessageOK(_t("msg.email_sent_to")."<b>$mailTo</b>");
			}
		} else {
			if ($message) {
				MSV_MessageError(_t("msg.email_sending_error"));
			}
		}
		
	} else {
		return false;
	}
	
	return true;
}

	
function MSV_PasswordGenerate($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}


function MSV_GetIP() {
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip  =$_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
}


function MSV_SitemapGenegate() {
    $sitemapPath = ABS."/sitemap.xml";
    
    if (!is_writable($sitemapPath)) {
    	MSV_MessageError("Can't write to $sitemapPath");
    	return false;
    }
    
    $sitemapXML = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
';
	$website = MSV_get("website");

	foreach ($website->languages as $langID) {
		$query = API_getDBList(TABLE_SEO, "`sitemap` > 0", "`url` asc", 10000, 0,  $langID);
		if ($query["ok"] && $query["data"]) {
			foreach ($query["data"] as $item) {
				$sitemapXML .= "
<url>
<loc>".HOME_LINK.$item["url"]."</loc>
<priority>1</priority>
<lastmod>".date("Y-m-d", strtotime($item["updated"]))."</lastmod>
</url>\n";
			}
		}
	}
	
	$sitemapXML .= "</urlset>";
	return file_put_contents($sitemapPath, $sitemapXML);
}


function MSV_HighlightText($s, $text, $c) {
	$text = strip_tags($text);
	$text = str_replace(array("&nbsp;","\n"), " ", $text);
	$text = array_map("trim", explode(" ", $text));
	
	$i = 0;
	$i_pos = 0;
	foreach ($text as $v) {
		if (!empty($v)) {
			$ar[] = $v;
			if (strstr($v, $s) && empty($i_pos)) $i_pos = $i;
			$i++;
		}
	}
	$i_pos = ($i_pos - $c) < 0 ? 0 : $i_pos - $c;
	for ($i = $i_pos; $i < ($c * 2 + $i_pos); $i++) {
		if (!empty($ar[$i])) $ar2[] = $ar[$i];
	}
	unset($ar);
   // var_dump(str_replace($s, "<strong>".$s."</strong>", implode(' ', $ar2)));
    // Создаем строку для регулярного выражения
    $pattern = "/((?:^|>)[^<]*)(".$s.")/si";
    // Подсвеченная строка
    $replace = '$1<b>$2</b>';
    
	return (empty($ar2) ? "" :  preg_replace($pattern, $replace, implode(' ', $ar2)));
}


// ********** Install Script ********


function CoreInstall($module) {

	// add site settings
	MSV_setConfig("include_html_head", "", true, "*");
	MSV_setConfig("theme_css_path", "", true, "*");
	MSV_setConfig("theme_js_path", "", true, "*");
	MSV_setConfig("theme_include_font", "", true, "*");
	MSV_setConfig("theme_use_bootstrap", 0, true, "*");
	MSV_setConfig("theme_use_jquery", 0, true, "*");
	
	// trigger email sending on user registration
	MSV_setConfig("email_registration", 1, true, "*");
	
	// add messages to default output
	MSV_setConfig("message_ok", "", true, "*");
	MSV_setConfig("message_error", "", true, "*");
	
	// mailing options
	MSV_setConfig("email_from", "admin@localhost", true, "*");
	MSV_setConfig("email_fromname", "Website", true, "*");
	
	
	// TODO: +++++ add mail templates
	
}



// ********** AJAX functions ********


function ajax_Get_Structure() {
	
	$structure = MSV_get("website.structure");
	//var_dump($structure);
	
	// TODO..
}

function ajax_Upload_Picture() {
	
	$allowedTypes = array(
		IMAGETYPE_PNG => "png", 
		IMAGETYPE_JPEG => "jpg", 
		IMAGETYPE_GIF => "gif"
	);
	
	if (!empty($_FILES["uploadFile"])) {
		
		$detectedType = exif_imagetype($_FILES["uploadFile"]['tmp_name']);
		if (array_key_exists($detectedType, $allowedTypes)) {
			
			$fileType = $allowedTypes[$detectedType];
			
			$table = $_REQUEST["table"];
			$field = $_REQUEST["field"];
			$itemID = $_REQUEST["itemID"];
			
			// TODO:
			// check $table and $field (config ..)
			
			// extract file information
			$file = $_FILES["uploadFile"];
			$fileName = $file["name"];
			if (!empty($itemID)) {
				$fileName = $itemID."-".$fileName;
			}
			
			// store Picture 
			$fileResult = MSV_storePic($file["tmp_name"], $fileType, $fileName, $table, $field);
			if (is_numeric($fileResult)) {
				echo CONTENT_URL."/".$fileResult;
			}
		} else {
			// error
			// file not allowed
		}
	}
}


// TODO: + use languages

function ajax_Get_Translit($module) {
       $res = array();
       
       $index = '';
       
       if (!empty($_REQUEST['index'])) {
        $index = $_REQUEST['index'];
       } else {
         if (!empty($_REQUEST['ttable'])) {
            $index = get_table_auto_increment_next_value($_REQUEST['ttable']);
         }
       }
        if (!empty($_REQUEST['code_str'])) {
                $res 	= array('success' 	=> 'ok',
         	 			'code_str' 		=> translit_encode(str_trunc(((!empty($index)? $index.'-':'').$_REQUEST['code_str']),150)));
        } else {
                $res 	= array('success' 	=> '',
         	 			'code_str' 		=> '');    
        }                
    

    return json_encode($res);
}


function get_table_auto_increment_next_value($table) {
  $sql = "SHOW TABLE STATUS FROM `".DB_NAME."` LIKE '$table'";

  $result = API_SQL($sql);
  $resultRow = MSV_SQLRow($result["data"]);
  
  return $resultRow['Auto_increment'];
 // return $db;
}
        
        
function translit_encode($string) {
	$trans_fwd = array(
        	'а'=>'a',
        	'б'=>'b',
        	'в'=>'v',
        	'г'=>'g',
        	'д'=>'d',
        	'е'=>'e',
        	'є'=>'e',
        	'ё'=>'e',
        	'ж'=>'zh',
        	'з'=>'z',
        	'и'=>'i',
        	'і'=>'i',
        	'ї'=>'i',
        	'й'=>'y',
        	'к'=>'k',
        	'л'=>'l',
        	'м'=>'m',
        	'н'=>'n',
        	'о'=>'o',
        	'п'=>'p',
        	'р'=>'r',
        	'с'=>'s',
        	'т'=>'t',
        	'у'=>'u',
        	'ф'=>'f',
        	'х'=>'h',
        	'ц'=>'c',
        	'ч'=>'ch',
        	'ш'=>'sh',
        	'щ'=>'sch',
        	'ъ'=>'',
        	'ы'=>'i',
        	'ь'=>'',
        	'э'=>'e',
        	'ю'=>'yu',
        	'я'=>'ya',
        	' '=>'-',
        	'-'=>'-',
        	'0'=>'0',
        	'1'=>'1',
        	'2'=>'2',
        	'3'=>'3',
        	'4'=>'4',
        	'5'=>'5',
        	'6'=>'6',
        	'7'=>'7',
        	'8'=>'8',
        	'9'=>'9',
        	'_'=>'-',
        	'('=>'',
        	')'=>'',
        	'a'=>'a',
        	'b'=>'b',
        	'c'=>'c',
        	'd'=>'d',
        	'e'=>'e',
        	'f'=>'f',
        	'g'=>'g',
        	'h'=>'h',
        	'i'=>'i',
        	'j'=>'j',
        	'k'=>'k',
        	'l'=>'l',
        	'm'=>'m',
        	'n'=>'n',
        	'o'=>'o',
        	'p'=>'p',
        	'q'=>'q',
        	'r'=>'r',
        	's'=>'s',
        	't'=>'t',
        	'u'=>'u',
        	'v'=>'v',
        	'w'=>'w',
        	'x'=>'x',
        	'y'=>'y',
        	'z'=>'z'
        );
	$result = '';
	$string = mb_strtolower($string, 'utf-8');
	for ($i = 0; $i < mb_strlen($string, 'utf-8'); $i++) {
		//$letter = mb_strtolower($string[$i], mb_detect_encoding($string));
		$letter = mb_substr($string, $i, 1, 'utf-8');
		if ($trans_fwd[$letter] !== NULL) {
			$result .= $trans_fwd[$letter];
		} else {
			$result .= '';
		}
	}
	return $result;
}
        
        
function str_trunc($str, $max_chars = 30) {
    $max_chars_tr = (int)round($max_chars*0.8);
    $sep = array(",", " ", ";", "(", "\\", "/", "-", ".");
    
    $s = $str;
    if (strlen($s) > $max_chars) {
        foreach ($sep as $v) {
            $a = strpos($s, $v, $max_chars_tr);
            if ($a !== false && $a < $max_chars) {
                return substr($s, 0, $a);
            }
        }
        return substr($s, 0, $max_chars);
    } else {
        return $s;
    }
}  
