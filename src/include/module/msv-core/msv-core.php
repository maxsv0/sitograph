<?php


function msv_start() {
    msv_log("Website: Start");

    msv_load_sitesettings();
    msv_load_sitestructure();
    msv_load_pagemenu();

    $website = msv_get("website");

    // load jQuery. Required by admin UI
    $theme_use_jquery = msv_get_config("theme_use_jquery");
    if ($theme_use_jquery > 0 || $website->requestUrl === "/admin/") {
        msv_include("/content/js/jquery.min.js");
    }

    // load Bootstrap. Required by admin UI
    $theme_use_bootstrap = msv_get_config("theme_use_bootstrap");
    if ($theme_use_bootstrap > 0 || $website->requestUrl === "/admin/") {
        msv_include("/content/css/bootstrap.min.css");
        msv_include("/content/js/bootstrap.min.js");
    }

    $theme_css_path = msv_get_config("theme_css_path");
    if (!empty($theme_css_path)) {
        msv_include($theme_css_path);
    }

    $theme_js_path = msv_get_config("theme_js_path");
    if (!empty($theme_js_path)) {
        msv_include($theme_js_path);
    }

    $message_ok = msv_get_config("message_ok");
    if (!empty($message_ok)) {
        msv_message_ok($message_ok);
    }
    $message_error = msv_get_config("message_error");
    if (!empty($message_error)) {
        msv_message_error($message_error);
    }

}

function msv_load() {
    $website = msv_get("website");

    msv_log("Website: Load");

    $website->load();

    msv_load_pagenavigation();
    msv_load_pagedocument();

    $includeHead = msv_get_config("include_html_head");
    $website->includeHead[] = $includeHead;

    // TODO: add more html part to config
}

function msv_output404() {
    $website = msv_get("website");

    $website->log("Page not found, loading 404 template");
    $website->loadPage("/404/");

    // reload page document
    msv_load_pagedocument();

    // output page 404 if exist
    if (!empty($website->page)) {
        header("HTTP/1.0 404 Not Found");
        $website->outputPage();
    }

    $website->outputNotFound();
}

function msv_output() {
    $website = msv_get("website");

    msv_log("Website: Output");

    if ($website->requestUrl === "/admin/" && $_REQUEST["section"] === "module_settings") {
        $admin_module_setup = msv_output_admin_modulesetup();
        msv_assign_data("admin_module_setup", $admin_module_setup);
    }

    if (defined("SHOW_ADMIN_MENU") && SHOW_ADMIN_MENU > 0) {
        if ($website->requestUrl !== "/admin/" && msv_check_accessuser("admin")) {
            $admin_menu = msv_output_admin_menu();

            $htmlFooter = msv_get_config("htmlFooter");
            $htmlFooter .= $admin_menu;

            $edit_mode = msv_get_config("edit_mode");
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

            $website->htmlFooter = $htmlFooter;
        }
    }

    // proccess post/get admin functions
    if (MSV_INSTALED && msv_check_accessuser("superadmin")) {
        msv_process_superadmin();
    }

    $website->outputPage();
}

function msv_load_pagedocument() {
    msv_log("Website -> LoadPageDocument");

    $website = msv_get("website");

    if (empty($website->page["page_document_id"])) {
        msv_log("page_document_id empty");
        return false;
    } else {
        msv_log("page_document_id -> ".$website->page["page_document_id"]);
    }

    $result = db_get(TABLE_DOCUMENTS, " `id` = '".(int)$website->page["page_document_id"]."'");
    if (!$result["ok"]) {
        msv_error($result["msg"]);
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
    if (msv_check_accessuser("admin")) {
        // if "edit_mode" is On, render save button under the text blocks and title
        $editMode = msv_get_config("edit_mode");
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

function msv_load_pagenavigation() {
    $page = msv_get("website.page");
    $structure = msv_get("website.structure");

    // set page navigation from current page
    build_page_navigation($page["id"]);

    // find Homepage and set it as a first element
    foreach ($structure as $item) {
        if ($item["url"] !== "/") {
            continue;
        }
        build_page_navigation($item["id"]);
    }
}

function build_page_navigation($itemID) {
    $structure = msv_get("website.structure");

    foreach ($structure as $item) {
        if ($item["id"] == $itemID) {
            if (empty($item["parent_id"])) {
                msv_set_navigation(
                    $item["name"],
                    $item["url"],
                    true
                );
            } else {
                // call recursively to find all parents
                build_page_navigation($item["parent_id"]);

                msv_set_navigation(
                    $item["name"],
                    $item["url"],
                    false
                );
            }
        }
    }
}


function msv_load_pagemenu() {
    msv_log("Website -> LoadPageMenu");

    $result = db_get_list(TABLE_MENU, "", "`order_id` asc");

    if (!$result["ok"]) {
        msv_error($result["msg"]);
    }
    $list = $result["data"];

    $menu = array();
    foreach ($list as $item) {
        $menuID = (string)$item["menu_id"];
        $menu[$menuID][] = $item;
    }

    $website =& msv_get("website");

    foreach ($menu as $menuID => $item) {
        $menuMy = array();

        // build 0 level menuMy
        foreach ($item as $itemMy) {
            if ($itemMy["parent_id"] > 0) continue;
            $menuMy[$itemMy["id"]] = $itemMy;
        }

        // build first level submenu
        foreach ($item as $itemSub) {
            if ($itemSub["parent_id"] > 0) {
                $menuMy[$itemSub["parent_id"]]["sub"][$itemSub["id"]] = $itemSub;
            }
        }

        $website->menu[$menuID] = array_values($menuMy);
    }
}

function msv_load_sitesettings() {
    msv_log("Website -> LoadSiteSettings");
    $result = db_get_list(TABLE_SETTINGS);

    if (!$result["ok"]) {
        msv_error($result["msg"]);
    }
    $list = $result["data"];
    $listSettings = array();
    foreach ($list as $item) {
        $param = (string)$item["param"];
        $value = (string)$item["value"];
        msv_set_config($param, $value);

        $listSettings[$param] = $item;
    }
    $website = msv_get("website");
    $website->configList = $listSettings;
}

function msv_load_sitestructure() {
    msv_log("Website -> LoadSiteStructure");
    $result = db_get_list(TABLE_STRUCTURE);

    if (!$result["ok"]) {
        msv_error($result["msg"]);
    }

    $website =& msv_get("website");

    $list = $result["data"];
    foreach ($list as $item) {
        $website->structure[] = $item;
    }

    return true;
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
function msv_enable_module($module) {
    msv_log("===== enableModule $module");

    $website = msv_get("website");

    // check $module if module is disabled

    $pathModuleDisabled = ABS_MODULE."/-".$module;
    $pathModuleEnabled = ABS_MODULE."/".$module;

    if (!file_exists($pathModuleDisabled)) return false;
    if (!is_dir($pathModuleDisabled)) return false;

    $pathModulePHP = $pathModuleDisabled."/".$module.".php";
    if (!file_exists($pathModulePHP)) return false;
    if (!is_readable($pathModulePHP)) return false;

    exec("mv ".escapeshellarg($pathModuleDisabled)." ".escapeshellarg($pathModuleEnabled));

    msv_log("===== enableModule OK");

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
function msv_disable_module($module) {
    msv_log("Website -> disableModule $module");

    $website = msv_get("website");

    // check if module is enabled

    $pathModuleDisabled = ABS_MODULE."/-".$module;
    $pathModuleEnabled = ABS_MODULE."/".$module;

    if (!file_exists($pathModuleEnabled)) return false;
    if (!is_dir($pathModuleEnabled)) return false;

    $pathModulePHP = $pathModuleEnabled."/".$module.".php";
    if (!file_exists($pathModulePHP)) return false;
    if (!is_readable($pathModulePHP)) return false;

    exec("mv ".escapeshellarg($pathModuleEnabled)." ".escapeshellarg($pathModuleDisabled));

    msv_log("===== disableModule OK");

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
function msv_remove_module($module) {
    // TODO: DO
    return false;

    msv_log("***** removeModule $module");
    // remove only disabled.

    $website = msv_get("website");

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
                db_remove_table($tableName);
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

    msv_log("Website -> removeModule OK");
    return true;
}

/**
 * List modules from repository
 *
 * Repository URL is stored in REP
 * Produces msv_message_error is case of error
 *
 * @return array List of modules
 */
function msv_list_modules() {
    msv_log("Website -> listModules");

    $cont = file_get_contents(REP);

    if (!$cont) {
        msv_message_error("Can't load URL: ".REP);
        return false;
    }

    $result = json_decode($cont, true);

    if ($result["ok"]) {
        $mosulesList = $result["data"];

        msv_log("Website -> listModules OK");

        return $mosulesList;
    } else {
        msv_message_error($result["msg"]);
    }

    return false;
}

/**
 * Install module from reposiroty
 *
 * Produces msv_message_error is case of error
 *
 * @param string $module Name of a module
 * @param boolean $redirect Optional Flag for running install hook for this module; defaults to true
 * @return boolean Result of the action
 */
function msv_install_module($module, $redirect = true) {
    msv_log("*****  installModule -> $module");

    $website = msv_get("website");

    // TODO add info, check
    $list = msv_list_modules();
    if (empty($list)) {
        msv_message_error("installModule -> $module "._t("msg.no_repository"));
        return false;
    }
    $moduleInfo = array();
    foreach ($list as $info) {
        if ($info["name"] == $module) {
            $moduleInfo = $info;
        }
    }
    if (empty($moduleInfo)) {
        msv_message_error("installModule -> $module "._t("msg.repository_not_found"));
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

//      $zipArchive = new PclZip($tmpFilename);
//      if (!$zipArchive->extract(PCLZIP_OPT_PATH, $tempDir) == 0) {
//              msv_error("installModule -> "._t("msg.cant_open_zip"));
//      }

    // try to extract using ZipArchive lib
    // in case of fail, use shell_exec
    if (class_exists("ZipArchive")) {
        $zipArchive = new ZipArchive();
        if (!$zipArchive->open($tmpFilename)) {
            msv_message_error("installModule -> "._t("msg.cant_open_zip"));
            return false;
        }
        $zipArchive->extractTo($tempDir);
        $zipArchive->close();
    } else {
        shell_exec("unzip $tmpFilename -d $tempDir");
    }

    // TODO:
    // check if files are in $tempDir/..

    $moduleObj = msv_get("website.".$module);
    if (!empty($moduleObj)) {

        // module exist, overwrite
        $fileList = $moduleObj->files;
    } else {
        // module first install

        $fileList = $moduleInfo["files"];
    }

    if (empty($fileList)) {
        msv_message_error("$module: File list empty");
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
            msv_message_error("Can't copy file $filePath. Destination path is empty.");
            return false;
        }

        if (!file_exists($filePath)) {
            msv_message_error("File not exist $filePath");
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

        msv_log("MSV copy: $filePath -> $fileCopyPath -> ".($r ? 'true' : 'false'));
    }


    if ($redirect) {
        msv_log("installModule -> redirect");
        $website->outputRedirect("/admin/?install_hook=".$module);
    }

    return true;
}

/**
 * TODO: rework
 *
 * Now is an alias for msv_install_module
 *
 * @param string $module Name of a module
 * @param boolean $redirect Optional Flag for running install hook for this module; defaults to true
 * @return boolean Result of the action
 */
function msv_reinstall_module($module, $redirect = true) {
    msv_log("***** reinstallModule");

    // TODO: check, reinstall ckeck??
    msv_install_module($module, $redirect);

    return true;
}

function msv_output_admin_menu() {
    $website = msv_get("website");

    $timestampEnd = time() + (float)substr((string)microtime(), 1, 8);
    $timestampStart = msv_get_config("timestampStart");
    $scriptTime = $timestampEnd - $timestampStart;
    $scriptTime = round($scriptTime, 6);

    $templateInfo = $website->template."/".$website->pageTemplate;
    $pageInfo = $scriptTime." sec";

    $strOut = '<table width="100%" cellpadding="0" cellspacing="0" class="admin_panel">';
    $strOut .= '<tbody><tr><td align="left" width="300">';
    $strOut .= '<a href="/admin/?toggle_edit_mode" class="link-dashed">Edit Mode</a> ';

    $edit_mode = msv_get_config("edit_mode");
    if ($edit_mode) {
        $strOut .= '<span class="label label-success">ON</span>';
        $strOut .= ' <small>'."<a href='/admin/?section=structure&table=structure&edit=".$website->page["id"]."'>settings</a>".' <span class=\'glyphicon glyphicon-edit\'></span></small>';
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
        $strOut .= "<a href='/admin/?section=editor&edit_file=/templates/".$templateInfo."&edit_mode'>";
        $strOut .= "<small>$templateInfo <span class='glyphicon glyphicon-edit'></span></small></a>";
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


function msv_output_admin_modulesetup() {
    $website = msv_get("website");
    $list = $website->modules;

    $strOut  = "";
    if (!isset($_GET["module"])) {
        $strOut .= "<div class=''>";
        $strOut .= "<h4>";
        $strOut .= "Repository: ";
        $headers = get_headers(REP);

        if(strpos($headers[0],'200')===false) {
            $strOut .= "<strong class='text-danger'>offline</strong>";
        } else {
            $strOut .= "<strong class='text-success'>online</strong>";
        }
        $strOut .= "</h4>";
        $strOut .= "<p><b>".REP."</b></p>";

        $strOut .= "<p>";
        $strOut .= "<a href='/admin/?section=module_settings&module_install' class='btn btn-lg btn-danger'><span class='glyphicon glyphicon-download'></span> install new module</a> &nbsp; &nbsp;";
        $strOut .= "<a href='/admin/?section=module_settings&module_update_all' class='btn btn-lg btn-danger'><span class='glyphicon glyphicon-download-alt'></span> update all</a> &nbsp; &nbsp;";
        $strOut .= "</p>";
    }

    if (!isset($_GET["module_install"])) {
        $strOut .= "<div>";
        $strOut .= "<h4 class='pull-left'>Navigate to module:</h4>";
        foreach ($list as $module) {
            $obj = $website->{$module};
            if ($obj->enabled) {
                $strOut .= "<a href='/admin/?section=module_settings&module=" . $obj->name . "' class='btn btn-primary" . (!empty($_GET["module"]) && $_GET["module"] === $module ? " active" : "") . "'>$module</a>";
            } else {
                $strOut .= "<a href='/admin/?section=module_settings&module=" . $module . "' class='btn btn-default" . (!empty($_GET["module"]) && $_GET["module"] === $module ? " active" : "") . "''>$module</a>";
            }
            $strOut .= "&nbsp; &nbsp;";
        }
        $strOut .= "</div>";
        $strOut .= "<br>";
    }
    $module = $_GET["module"];
    if (!empty($module)) {
        $strOut .= "<div class='infowell'>".msv_build_module_info($module)."</div>";
    }
    if (isset($_GET["module_install"])) {
        $listRep = msv_list_modules();
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

function msv_build_module_info($module) {
    $objModule = msv_get("website.".$module);

    $module_params = array(
        "name","version", "date", "title", "description", "tags", "author", "preview",
        "activationUrl", "activationLevel", "adminMenu", "adminMenuOrder", "itemsPerPage",
        "previewItemsCount", "baseUrl", "pageUrlParam", "searchUrlParam",
        "accessAPIList", "accessAPIDetails", "accessAPIAdd", "accessAPIEdit", "accessAPICategory", "accessAPIAlbum",
    );

    $str =  "<h2>".$objModule->title."</h2>";
    $str .= '<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#config">Config</a></li>
  <li><a data-toggle="tab" href="#tables">Tables</a></li>
  <li><a data-toggle="tab" href="#install">Install</a></li>
  <li><a data-toggle="tab" href="#locales">Locales</a></li>
  <li><a data-toggle="tab" href="#php">Custom PHP</a></li>
  <li><a data-toggle="tab" href="#actions">'._t("actions").'</a></li>
</ul>

<div class="tab-content">
  <div id="config" class="tab-pane fade in active">
    <h3>Module Configuration</h3>
    <table class="table table-hover">
    <tr><th>Parameter</th><th>Value</th></tr>
';
    foreach ($module_params as $param) {
        $value = $objModule->{$param};
        $str .= "<tr><td>$param</td><td>".(string)$value."</td></tr>\n";
    }

    $str .= '
    </table>
  </div>
  <div id="tables" class="tab-pane fade">';
    foreach ($objModule->tables as $tableName => $tableInfo) {
        $str .= "<h3>Table Definition</h3>";
        $str .= "<table class=\"table table-hover\">
    <tr><th>Parameter</th><th>Value</th></tr>";
        $str .= "<tr><td>Table Name</td><td>".$tableInfo["name"]."</td></tr>\n";
        $str .= "<tr><td>Index field</td><td>".$tableInfo["index"]."</td></tr>\n";
        $str .= "<tr><td>Title field</td><td>".$tableInfo["title"]."</td></tr>\n";
        $str .= "<tr><td>UseSEO</td><td>".$tableInfo["useseo"]."</td></tr>\n";
        $str .= "</table>\n";

        $str .= "<h3>Table Fields</h3>";
        $str .= "<table class=\"table table-hover\">
    <tr><th>Name</th><th>Type</th><th>ListSkip</th></tr>";
        foreach ($tableInfo["fields"] as $fieldInfo) {
            $str .= "<tr><td>".$fieldInfo["name"]."</td><td>".$fieldInfo["type"]."</td><td>".$fieldInfo["listskip"]."</td></tr>\n";
        }
        $str .= "</table>\n";
    }

    if (empty($objModule->tables)) {
        $str .= "<div class='alert alert-warning'>No tables found for this module</div>";
    }
    $str .= '
  </div>
  <div id="install" class="tab-pane fade">
    <h3>Module dependency</h3>
    <table class="table table-hover">
    <tr><th>Name</th><th>Version</th></tr>
';
    foreach ($objModule->dependency as $fileInfo) {
        $str .= "<tr><td>".$fileInfo["module"]."</td><td>".$fileInfo["version"]."</td></tr>\n";
    }
    $str .= '
    </table>
    <h3>List of a files</h3>
    <table class="table table-hover">
    <tr><th>File Path</th><th>Size</th><th>Access</th></tr>
';
    foreach ($objModule->files as $fileInfo) {
        $trStyle = "";
        if (!is_readable($fileInfo["abs_path"])) {
            $trStyle = "danger";
        } elseif (!is_writable($fileInfo["abs_path"])) {
            $trStyle = "warning";
        }

        $str .= "<tr class='$trStyle'>";
        $str .= "<td>".$fileInfo["local_path"]."</td>";
        if (is_readable($fileInfo["abs_path"])) {
            $info = stat($fileInfo["abs_path"]);
            $str .= "<td>" . msv_format_size($info["size"]) . "</td>";

            if (is_writable($fileInfo["abs_path"])) {
                $str .= "<td class='text-success'>write</td>";
            } else {
                $str .= "<td class='text-danger'>read</td>";
            }
        } else {
            $str .= "<td colspan='2' class='text-center'><i>not found</i></td>";
        }
        $str .= "</tr>\n";
    }
    $str .= '
    </table>
  </div>
  <div id="locales" class="tab-pane fade">
    <h3>Locales and texts</h3>
    <table class="table table-hover">
    <tr><th>Text ID</th><th>Value</th></tr>
';
    foreach ($objModule->locales as $textID => $textValue) {
        $str .= "<tr><td>$textID</td><td>$textValue</td></tr>\n";
    }
    $str .= "</table>\n";

    if (empty($objModule->locales)) {
        $str .= "<div class='alert alert-warning'>No locales found for this module</div>";
    }
    $str .= '
  </div>
  <div id="php" class="tab-pane fade">
    <h3>Custom PHP</h3>

<form class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-4">PHP Controllers:</label>
	<div class="col-sm-8">
	<pre>';
    foreach ($objModule->pathModuleController as $pathController) {
        $str .= "<p>$pathController</p>";
    }
    $str .= '</pre>
	</div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="imodule_php">
    Custom PHP Controller Source';
    if (is_writable($fileInfo["abs_path"])) {
        $str .= "<p class='text-success'><b>writable</b></p>";
    } else {
        $str .= "<p class='text-danger'>NO WRITE ACCESS</p>";
    }
    $str .= '</label>
	<div class="col-sm-8">
		<textarea class="form-control" id="imodule_php" name="module_php" rows="15">';
    $str .= htmlspecialchars(file_get_contents($pathController));
    $str .= '</textarea>
	</div>
  </div>
</form>
  </div>
  
  <div id="actions" class="tab-pane fade">';
    foreach ($objModule->tables as $tableName => $tableInfo) {
        $str .= "<h3>Table '".$tableInfo["name"]."'</h3>";
        $str .= "<p>";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=remove' class='btn btn-danger btn-xs'>remove table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=truncate' class='btn btn-danger btn-xs'>truncate table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=create' class='btn btn-primary btn-xs'>create table</a> ";
        $str .= "</p>";
    }
  $str .=  '</div>
</div>

';
    return $str;
}

// process `superadmin` functions
//      available functions:
//          - module_update_all
//          - terminal execute
//          - module_install
//          - module_reinstall
//          - module_enable
//          - module_disable
//          - module_remove                 <============ TODO: this is not working
//          - run module install hook
//          - table create
//          - table truncate
//          - table remove
//
function msv_process_superadmin() {
    if (!msv_check_accessuser("superadmin")) return false;

    if (isset($_GET["module_update_all"])) {
        msv_update_allmodules();
    }

    if (!empty($_GET["terminal_code"])) {
        $code = "return ".$_GET["terminal_code"];
        $result = eval($code);
        msv_assign_data("terminal_code", $_GET["terminal_code"]);
        msv_assign_data("terminal_result", $result);
    }

    if (!empty($_GET["module_remove"])) {
        // TODO: DO
        // TODO: check $_GET["module_remove"]
        //msv_remove_module($_GET["module_remove"]);
    }
    if (!empty($_GET["module_disable"])) {
        // TODO: check $_GET["module_disable"]
        msv_disable_module($_GET["module_disable"]);
    }

    if (!empty($_GET["module_enable"])) {
        // TODO: check $_GET["module_enable"]
        msv_enable_module($_GET["module_enable"]);
    }

    if (!empty($_GET["module_reinstall"])) {
        // TODO: check $_GET["module_reinstall"]
        msv_reinstall_module($_GET["module_reinstall"], false);
    }

    if (!empty($_GET["table_action"])) {
        // TODO: check $_GET["module"]
        // TODO: check $_GET["table"]

        $result = array();
        if ($_GET["table_action"] === "create") {

            $result = db_create_table($_GET["module_table"]);

        } elseif ($_GET["table_action"] === "truncate") {

            $result = db_empty_table($_GET["module_table"]);

        } elseif ($_GET["table_action"] === "remove") {

            $result = db_remove_table($_GET["module_table"]);

        }

        if (!empty($result)) {
            if ($result["ok"]) {
                msv_message_ok($result["sql"]);
                msv_message_ok($result["msg"]);
            } else {
                msv_message_error($result["sql"]);
                msv_message_error($result["msg"]);
            }
        }

    }

    if (!empty($_GET["module_install"])) {
        // TODO: check $_GET["module_install"]
        $module = $_GET["module_install"];

        msv_install_module($module);
    }

    if (!empty($_GET["install_ok"])) {
        msv_message_ok("<b>{$_GET["install_ok"]}</b> installed successfully");
    }
    if (!empty($_GET["install_hook"])) {
        // TODO: check $_GET["install_hook"]

        $module = $_GET["install_hook"];

        $obj = msv_get("website.".$module);

        if (!$obj) {
            msv_message_error("Error while installing {$module}");
        } else {
            if (!empty($obj->tables)) {
                $tableList = $obj->tables;
                if (!empty($tableList)) {
                    foreach ($tableList as $tableName => $tableInfo) {
                        $result = db_create_table($tableName);
                    }
                }
            }
            $obj->runInstallHook();

            msv_redirect("/admin/?section=module_settings&install_ok=".$module."&module=".$module."&module_install");
        }
    }

    return true;
}
