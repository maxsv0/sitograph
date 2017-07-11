<?php


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

            $edit_mode = MSV_getConfig("edit_mode");
            if ($edit_mode) {
                $htmlFooter .= '
<!-- Modal Edit form -->
<div class="modal fade" id="adminModal" role="dialog">
	<div class="modal-dialog" style="width: 90%; height: 90%; margin:auto auto; padding: 0;">
		<div class="modal-content" style="height: 100%; min-height: 100%; border-radius: 0;">
			<div class="modal-body" style="height: 100%;">
				<iframe id="modal-frame" src="about:blank" width="100%" height="100%" style="display: block;border:0;height:100%;width:100%"></iframe>
			</div>
			<div class="modal-footer" style="background:#fff;">
			    sss
			</div>
		</div>
		</div>
	</div>
</div>
';
            }

			MSV_setConfig("htmlFooter", $htmlFooter);
		}
	}

	$website->outputPage();
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
    if (!$result["ok"]) {
        MSV_ERROR($result["msg"]);
        return false;
    }

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

    // admin features
    if (MSV_checkAccessUser("admin")) {
        // if "edit_mode" is On, render save button under the text blocks and title
        $editMode = MSV_getConfig("edit_mode");
        if ($editMode) {
            $documentNew = "<form action='/api/document/edit/' method='post' class='form-text-inline'>";
            $documentNew .= "<div class='editor-inline'>" . $document["text"] . "</div>";
            $documentNew .= "<div class='clearfix well admin_block'>
<button type='submit' class='btn btn-primary'><span class=\"glyphicon glyphicon-ok\">&nbsp;</span>Save Document</button>
<button type='reset' class='btn btn-danger'><span class=\"glyphicon glyphicon-ban-circle\">&nbsp;</span>Reset</button>
<span class='alert'></span>
<input type='hidden' value='text' name='updateName'>
<input type='hidden' value='" . $document["id"] . "' name='updateID'>
</div>";
            $documentNew .= "</form>";
            $document["text"] = $documentNew;

            $documentNew = "<form action='/api/document/edit/' method='post'  class='form-text-inline'>";
            $documentNew .= "<div class='editor-inline' name='postValue'>" . $document["name"] . "</div>";
            $documentNew .= "<div class='clearfix well admin_block'>
<button type='submit' class='btn btn-primary'><span class=\"glyphicon glyphicon-ok\">&nbsp;</span>Save Document Title</button>
<button type='reset' class='btn btn-danger'><span class=\"glyphicon glyphicon-ban-circle\">&nbsp;</span>Reset</button>
<span class='alert'></span>
<input type='hidden' value='name' name='updateName'>
<input type='hidden' value='" . $document["id"] . "' name='updateID'>
</form></div>";
            $document["name"] = $documentNew;
        }
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

/**
 * Enable disabled module
 * 
 * Module is considered as disabled if its folder name starts with '-'
 * Rename module folder and refreshes a page
 *
 * @param string $module Name of a module
 * @return boolean Result of the action
 */
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
	
	$website->outputRedirect("/admin/?section=module_settings&module=".$module);
	
	return true;
}

/**
 * Disable active module
 * 
 * Module is considered as disabled if its folder name starts with '-'
 * Rename module folder and refreshes a page
 *
 * @param string $module Name of a module
 * @return boolean Result of the action
 */
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
	
	$website->outputRedirect("/admin/?section=module_settings&module=".$module);
	
	return true;
}

/**
 * TODO: rework this and test
 * 
 *
 * @param string $module Name of a module
 * @return boolean Result of the action
 */
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

/**
 * List modules from repository
 * 
 * Repository URL is stored in REP
 * Produces MSV_MessageError is case of error
 *
 * @return array List of modules
 */
function MSV_listModules() {
	MSV_Log("Website -> listModules");
	
	$cont = file_get_contents(REP);
	
	if (!$cont) {
		MSV_MessageError("Can't load URL: ".REP);
		return false;
	}
	
	$result = json_decode($cont, true);

	if ($result["ok"]) {
		$mosulesList = $result["data"];
		uasort($mosulesList, "cmp_modules_list");
		
		MSV_Log("Website -> listModules OK");
		
		return $mosulesList;
	} else {
		MSV_MessageError($result["msg"]);
	}
	
	return false;
}

function cmp_modules_list($a, $b) {
    return strcmp($a["title"], $b["title"]);
}

/**
 * Install module from reposiroty
 * 
 * Produces MSV_MessageError is case of error
 *
 * @param string $module Name of a module
 * @param boolean $redirect Optional Flag for running install hook for this module; defaults to true
 * @return boolean Result of the action
 */
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
			MSV_MessageError("installModule -> "._t("msg.cant_open_zip"));
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
		MSV_MessageError("$module: File list empty");
		return false;
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
			MSV_MessageError("Can't copy file $filePath. Destination path is empty.");
			return false;
		}
		
		if (!file_exists($filePath)) {
			MSV_MessageError("File not exist $filePath");
			return false;
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

/**
 * TODO: rework
 * 
 * Now is an alias for MSV_installModule
 *
 * @param string $module Name of a module
 * @param boolean $redirect Optional Flag for running install hook for this module; defaults to true
 * @return boolean Result of the action
 */
function MSV_reinstallModule($module, $redirect = true) {
	MSV_Log("***** reinstallModule");
	
	// TODO: check, reinstall ckeck??
	MSV_installModule($module, $redirect);

	return true;
}

function MSV_outputAdminMenu() {
	$website = MSV_get("website");

    $timestampEnd = time() + (float)substr((string)microtime(), 1, 8);
    $timestampStart = MSV_getConfig("timestampStart");
    $scriptTime = $timestampEnd - $timestampStart;
    $scriptTime = round($scriptTime, 6);

    $docInfo = "<a href='/admin/?section=structure&table=structure&edit=".$website->page["id"]."'>page setup</a>";
    $templateInfo = $website->template."/".$website->pageTemplate;
    $pageInfo = $scriptTime." sec";

    $strOut = '<table width="100%" cellpadding="0" cellspacing="0" class="admin_panel">';
    $strOut .= '<tbody><tr><td align="left" width="300">';
    $strOut .= '<a href="/admin/?toggle_edit_mode" class="link-dashed">Edit Mode</a> ';

    $edit_mode = MSV_getConfig("edit_mode");
    if ($edit_mode) {
        $strOut .= '<span class="label label-success">ON</span>';
        $strOut .= ' <small>'.$docInfo.'</small>';
    } else {
        $strOut .= '<span class="label label-danger">OFF</span>';
    }
    $strOut .= '</td><td align="center">';
    $strOut .= '<p>'._t("title.back_to_admin").'';
    $strOut .= '<a href="/admin/">';
    $strOut .= '<span class="admin_pic">&nbsp;</span>';
    $strOut .= '<span class="admin_title">'._t("btn.back_to_admin").'</span>';
    $strOut .= '</a>';
    $strOut .= '</p></td>';
    $strOut .= '<td align="center" width="200">';
    if ($edit_mode) {
        $strOut .= "<small>$templateInfo</small>";
    }
    $strOut .=' <td align="center" width="100">';
    if ($edit_mode) {
        $strOut .= "<a href='#' data-toggle=\"collapse\" data-target=\"#debugLog\"><small class='link-dashed'>$pageInfo</small><span class=\"caret\"></span></a>";
    }
    $strOut .= '</td></tr></tbody></table>';
    if ($edit_mode) {
        if (DEBUG) {
            $websiteLog = $website->logDebug;
        } else {
            $websiteLog = $website->log;
        }
        $strOut .= "<div id=\"debugLog\" class=\"collapse\"><pre>".$websiteLog."</pre></div>";
    }
    $strOut .= '<style>';
    $strOut .= 'body {padding-top:30px;}';
    $strOut .= '</style>';

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
					$strOut .= " <small>".MSV_formatSize($info["size"])."</small>";
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
