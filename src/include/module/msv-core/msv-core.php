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


    $ctx = stream_context_create(array('http'=>
        array(
            'timeout' => 5,
        )
    ));

    $cont = file_get_contents(REP, false, $ctx);

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
    if (empty($moduleCont)) {
        msv_message_error("Can't load archive from URL $moduleUrl");
        return false;
    }

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
    return msv_install_module($module, $redirect);
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
    $strOut .= '<tbody><tr><td align="left" width="30%">';
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

    if ($edit_mode) {
        $strOut .= '<td align="center" width="20%">';
        $strOut .= "<a href='/admin/?section=editor&edit_file=/templates/".$templateInfo."&edit_mode'>";
        $strOut .= "<small>$templateInfo <span class='glyphicon glyphicon-edit'></span></small></a>";
        $strOut .=' <td align="center" width="10%">';
        $strOut .= "<a href='#' data-toggle=\"collapse\" data-target=\"#debugLog\"><small class='link-dashed'>$pageInfo</small><span class=\"caret\"></span></a>";
    } else {
        $strOut .= '<td align="center" width="30%">';
        $configCMS = msv_get_user_config("cms");
        if (!empty($configCMS) && !empty($configCMS["favorites"])) {
            foreach ($configCMS["favorites"] as $favID => $favItem) {
                $strOut .= "<a href='".$favItem["url"]."' class='admin_title'>".$favItem["text"]."</a> &nbsp;&nbsp;&nbsp;";
            }
        }

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

    $strOut  = "<div class='row'>";

    if (!isset($_GET["module_install"])) {
        $strOut .= "<div class='col-lg-8'>";
        if (!empty($_GET["module"])) {
            $obj = $website->{$_GET["module"]};
            $strOut .= "<h4><a href='/admin/?section=module_settings'>Installed modules</a> &gt; ".$obj->title."</h4>";
        } else {
            $strOut .= "<h4>Installed modules</h4>";
        }

        $strOut .= "<table class='table table-hover'>";
        foreach ($list as $module) {
            if (!empty($_GET["module"]) && $_GET["module"] !== $module) {
                continue;
            }

            $obj = $website->{$module};
            $strOut .= "<tr>";
            $strOut .= "<td class='col-sm-3'>";
            $strOut .= $obj->config["title"];
            $strOut .= "</td>";
            $strOut .= "<td class='col-sm-1'>";
            $strOut .= $obj->config["version"];
            $strOut .= "</td>";
            $strOut .= "<td class='col-sm-4'>".LOCAL_MODULE."/$module</td>";
            $strOut .= "<td class='col-sm-1'></td>";
            $strOut .= "<td class='col-sm-1'>";
            if ($obj->enabled) {
                $strOut .= "<span class='label label-success'>enabled</span>";
            } else {
                $strOut .= "<span class='label label-warning'>disabled</span>";
            }
            $strOut .= "<td>";
            $strOut .= "<td class='col-sm-2'>";
            $strOut .= "<a href='/admin/?section=module_settings&module=" . $obj->name . "' class='btn btn-primary'><span class='glyphicon glyphicon-cog'></span> configure</a>";
            $strOut .= "</td>";
            $strOut .= "</tr>";
        }
        $strOut .= "</table>";
        $strOut .= "</div>";
        $strOut .= "<br>";
    } else {
        $strOut .= "<div class='col-lg-8'>";
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
        $strOut .= "</div>";
    }

    $strOut .= "<div class='col-lg-4'>";
    $strOut .= "<div class='well text-center'>";
    $strOut .= "<h4>";
    $strOut .= "Repository: ";

    $ctx = stream_context_create(array('http'=>
        array(
            'timeout' => 5,
        )
    ));

    $cont = file_get_contents(REP, false, $ctx);
    if(empty($cont)) {
        $strOut .= "<strong class='text-danger'>offline</strong>";
    } else {
        $strOut .= "<strong class='text-success'>online</strong>";
    }
    $strOut .= "</h4>";
    $urlInfo = parse_url(REP);
    $strOut .= "<p><b>".$urlInfo["host"]."</b></p>";
    $strOut .= "<p>";
    $strOut .= "<a href='/admin/?section=module_settings&module_install' class='btn btn-lg btn-danger'><span class='glyphicon glyphicon-download'></span> Add Module</a> &nbsp; &nbsp;";
    $strOut .= "</p>";
    $strOut .= "</div>";
    $strOut .= "</div>";

    if (!empty($_GET["module"])) {
        $strOut .= "<div class='col-sm-10 col-sm-offset-1 infowell'>".msv_build_module_info($_GET["module"])."</div>";
    }
    $strOut .= "</div>";
    $strOut .= "<br>\n";
    $strOut .= "<div class='row'>";
    $strOut .= "<div class='col-sm-6'>";
    $strOut .= "<a href='/admin/?section=module_settings&module_update_all' class='btn btn-lg btn-danger'><span class='glyphicon glyphicon-refresh'></span> update all</a> &nbsp; &nbsp;";
    $strOut .= "<a href='/admin/?section=module_settings&module_install' class='btn btn-lg btn-danger'><span class='glyphicon glyphicon-download'></span> install new module</a> &nbsp; &nbsp;";
    $strOut .= "</div>";
    $strOut .= "<div class='col-sm-6 text-right'>";
    $strOut .= "<a href='/admin/?section=export&full' class='btn btn-lg btn-primary'><span class='glyphicon glyphicon-download-alt'></span> Download Website Backup</a> &nbsp; &nbsp;";
    $strOut .= "</div>";
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

    $str =  "<h1 class='text-center'>".$objModule->config["title"]."</h1>";
    $str .= '<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#config">Config</a></li>
  <li><a data-toggle="tab" href="#tables">Tables</a></li>
  <li><a data-toggle="tab" href="#install">Install</a></li>
  <li><a data-toggle="tab" href="#locales">Locales</a></li>
  <li><a data-toggle="tab" href="#php">PHP</a></li>
  <li><a data-toggle="tab" href="#actions">'._t("actions").'</a></li>
</ul>

<div class="tab-content">
  <div id="config" class="tab-pane fade in active">
    <h4>Module Configuration</h4>';

    $str .= "<div class='well text-center'>";
    $str .= '<a href="/admin/?section=editor&edit_file='.LOCAL_MODULE.'/'.$objModule->name.'/config.xml" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Module XML</a> &nbsp;&nbsp;';
    if (file_exists(ABS_MODULE.'/'.$objModule->name.'/config.locales.xml')) {
        $str .= '<a href="/admin/?section=editor&edit_file='.LOCAL_MODULE.'/'.$objModule->name.'/config.locales.xml" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Locales XML</a> &nbsp;&nbsp;';
    } else {
        $str .= '<a href="#" class="btn btn-primary btn-lg disabled"><span class="glyphicon glyphicon-edit"></span> Edit Locales XML</a> &nbsp;&nbsp;';
    }
    if (file_exists(ABS_MODULE.'/'.$objModule->name.'/config.install.xml')) {
        $str .= '<a href="/admin/?section=editor&edit_file='.LOCAL_MODULE.'/'.$objModule->name.'/config.install.xml" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Install XML</a>';
    } else {
        $str .= '<a href="#" class="btn btn-primary btn-lg disabled"><span class="glyphicon glyphicon-edit"></span> Edit Install XML</a>';
    }
    $str .= '</div>';

    $str .= '<table class="table table-hover">';
    foreach ($module_params as $param) {
        $value = $objModule->{$param};
        $str .= "<tr><td>$param</td><td>".(string)$value."</td></tr>\n";
    }
    $str .= '
    </table>
  </div>
  <div id="tables" class="tab-pane fade">';
    foreach ($objModule->tables as $tableName => $tableInfo) {
        $str .= "<div class='row'><div class='col-sm-12'>";
        $str .= "<h3>".DB_HOST.": ".DB_NAME.": ".$tableInfo["name"]."</h3>";
        $str .= "</div>\n";
        $str .= "<div class='col-sm-5'>";
        $str .= "<h4>Definition</h4>";
        $str .= "<table class=\"table table-hover\">";
        $str .= "<tr><td>Table Name</td><td>".$tableInfo["name"]."</td></tr>\n";
        $str .= "<tr><td>Index field</td><td>".$tableInfo["index"]."</td></tr>\n";
        $str .= "<tr><td>Title field</td><td>".$tableInfo["title"]."</td></tr>\n";
        $str .= "<tr><td>UseSEO</td><td>".$tableInfo["useseo"]."</td></tr>\n";
        $str .= "</table>\n";
        $str .= "<br>\n";
        $str .= "<h4>Info</h4>";

        $resultCount = db_get_count($tableInfo["name"]);
        $tableExists = true;
        if (!$resultCount["ok"]) {
            $str .= "<div class='alert alert-warning'>".$resultCount["msg"]."</div>";
            $tableExists = false;
        }
        $str .= "<p>Table size: ";
        $str .= $resultCount["data"]." rows";
        $str .= "&nbsp;&nbsp;&nbsp;";
        if ($tableExists) {
            $str .= " <a href='/admin/?section=export&table=".$tableInfo["name"]."&export_full' class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-download'></span> Export CSV</a> ";
        } else {
            $str .= " <a href='#' class='btn btn-primary disabled'><span class='glyphicon glyphicon-download'></span> Export CSV</a> ";
        }
        $str .= "</p>";
        $str .= "<p><a href=\"/admin/?section=editor&edit_file=".LOCAL_MODULE."/".$objModule->name."/config.xml\" class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-edit'></span> Edit XML definition</a></p>";
        $str .= "<p class='well'>";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=remove#tables' class='btn btn-danger".($tableExists ? "" : " disabled")."'><span class='glyphicon glyphicon-remove'></span> remove table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=truncate#tables' class='btn btn-danger".($tableExists ? "" : " disabled")."''><span class='glyphicon glyphicon-trash'></span> truncate table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=create#tables' class='btn btn-warning".($tableExists ? " disabled" : "")."''><span class='glyphicon glyphicon-plus'></span> create table</a> ";
        $str .= "</p>";
        $str .= "</div><div class='col-sm-7'>";
        $str .= "<h4>Fields definition</h4>";
        $str .= "<table class=\"table table-hover\">
    <tr><th class=\"col-sm-4\">Name</th><th class=\"col-sm-3\">Type</th><th class=\"col-sm-5\">Options</th></tr>";
        foreach ($tableInfo["fields"] as $fieldInfo) {
            if ($fieldInfo["name"] === $tableInfo["index"]) {
                $str .= "<tr class='info'>";
            } elseif ($fieldInfo["name"] === $tableInfo["title"]) {
                $str .= "<tr class='info'>";
            } else {
                $str .= "<tr>";
            }
            $str .= "<td>".$fieldInfo["name"]."</td><td>".$fieldInfo["type"]."</td>";
            $str .= "<td>";
            if ($fieldInfo["name"] === $tableInfo["index"]) {
                $str .= "<p><span class='label label-success'>INDEX</span></p>";
            }
            if ($fieldInfo["name"] === $tableInfo["title"]) {
                $str .= "<p><span class='label label-success'>TITLE</span></p>";
            }
            if ($fieldInfo["listskip"]) {
                $str .= "<p><span class='label label-info'>SKIP</span></p>";
            }
            if ($fieldInfo["max-height"]) {
                $str .= "<p>Max Height: <span class='label label-success'>".$fieldInfo["max-height"]."</span></p>";
            }
            if ($fieldInfo["max-width"]) {
                $str .= "<p>Max Width: <span class='label label-success'>".$fieldInfo["max-width"]."</span></p>";
            }
            if ($fieldInfo["select-from"]) {
                $str .= "<p>Select from <span class='label label-success'>".$fieldInfo["select-from"]["source"]."</span> ";
                $str .= "<span class='label label-success'>".$fieldInfo["select-from"]["name"]."</span>";

                $str .= ", filter <span class='label label-success'>";
                if ($fieldInfo["select-from"]["filter"]) {
                    $str .= $fieldInfo["select-from"]["filter"];
                } else {
                    $str .= "null";
                }
                $str .= "</span>";

                $str .= ", order <span class='label label-success'>";
                if ($fieldInfo["select-from"]["order"]) {
                    $str .= $fieldInfo["select-from"]["order"];
                } else {
                    $str .= "order";
                }
                $str .= "</span>";
                $str .= "<p>";
            }
            $str .= "</td></tr>\n";
        }
        $str .= "</table>\n";
        $str .= "</div></div>\n";
    }

    if (empty($objModule->tables)) {
        $str .= "<div class='alert alert-warning'>No tables found for this module</div>";
    }
    $str .= '
  </div>
  <div id="install" class="tab-pane fade">
    <h4>Module dependency</h4>
    <table class="table table-hover">
    <tr><th class="col-sm-5">Name</th><th>Version</th></tr>
';
    foreach ($objModule->dependency as $fileInfo) {
        $str .= "<tr><td>".$fileInfo["module"]."</td><td>".$fileInfo["version"]."</td></tr>\n";
    }
    $str .= '
    </table>
    <h4>List of a files</h4>
    <table class="table table-hover">
    <tr><th class="col-sm-7">File Path</th><th>Size</th><th>Access</th></tr>
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
    <h4>Locales and texts</h4>';
    $str .= "<div class='well text-center'>";
    if (file_exists(ABS_MODULE.'/'.$objModule->name.'/config.locales.xml')) {
        $str .= '<a href="/admin/?section=editor&edit_file='.LOCAL_MODULE.'/'.$objModule->name.'/config.locales.xml" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Locales XML</a> &nbsp;&nbsp;';
    } else {
        $str .= '<a href="/admin/?section=editor&edit_file='.LOCAL_MODULE.'/'.$objModule->name.'/config.xml" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-edit"></span> Edit Locales XML</a> &nbsp;&nbsp;';
    }
    $str .= '<a href="/admin/?section=locales#module-'.$objModule->name.'" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-cog"></span> Manage Translations</a>';
    $str .= '</div>
    <table class="table table-hover">
    <tr><th class="col-sm-5">Text ID</th><th>Value</th></tr>
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
    <h4>PHP Controllers</h4>

<form class="form-horizontal">';
    foreach ($objModule->pathModuleController as $pathController) {
        $str .= "<div class=\"form-group\">";
        $str .= "<label class=\"control-label col-sm-12\">";
        $str .= "$pathController";
        if (is_writable($fileInfo["abs_path"])) {
            $str .= "<span class='pull-right text-success'><b>writable</b></span>";
        } else {
            $str .= "<span class='pull-right text-danger'>NO WRITE ACCESS</span>";
        }
        $str .= "</label>";
        $str .= '</label>
	<div class="col-sm-12">
		<textarea class="form-control" id="imodule_php" name="module_php" rows="15">';
        $str .= htmlspecialchars(file_get_contents($pathController));
        $str .= '</textarea>';
        $str .= "</div>";
        $str .= "</div>";
    }
    $str .= '
</form>
  </div>
  
  <div id="actions" class="tab-pane fade">';
    $str .= "<h4>Module actions</h4>";
    $str .= "<p class='well text-center'>";
    // TODO: Export module feature
    $str .= "<a href='/admin/?section=export&module=".$objModule->name."' class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-download'></span> Export ZIP</a>&nbsp; &nbsp; ";
    $str .= "<a href='/admin/?module_reinstall=".$objModule->name."' class='btn btn-warning btn-lg' onclick=\"if(!confirm('Are you sure? Current module files will be overwritten.')) return false;\"><span class='glyphicon glyphicon-refresh'></span> update module</a>&nbsp; &nbsp; ";
    if ($objModule->enabled) {
        $str .= "<a href='/admin/?module_disable=".$objModule->name."' class='btn btn-danger btn-lg'><span class='glyphicon glyphicon-remove'></span> disable module</a>";
    } else {
        $str .= "<a href='/admin/?module_enable=".$objModule->name."' class='btn btn-danger btn-lg'><span class='glyphicon glyphicon-ok'></span> enable module</a>";
    }
    //$str .= "&nbsp; &nbsp; ";
    //$str .= "<a href='/admin/?module_remove=".$objModule->name."' class='btn btn-danger btn-lg disabled' onclick=\"if(!confirm('ALL DATA WILL BE LOST! Are you sure?')) return false;\"><span class='glyphicon glyphicon-ban-circle'></span> Remove</a> &nbsp; &nbsp;";
    $str .= "</p>";

    $str .= "<h4>Table actions</h4>";
    $str .= "<table class='table table-hover'>";
    foreach ($objModule->tables as $tableName => $tableInfo) {
        $str .= "<tr>";
        $str .= "<td class='col-sm-2 col-sm-offset-1'><p>".$tableInfo["name"]."</p></td>";

        $resultCount = db_get_count($tableInfo["name"]);
        $tableExists = true;
        if ($resultCount["ok"]) {
            $str .= "<td class='col-sm-2'>";
            $str .= $resultCount["data"]." rows";
            $str .= "</td>";
            $str .= "<td class='col-sm-2'>";
            $str .= " <a href='/admin/?section=export&table=".$tableInfo["name"]."&export_full' class='btn btn-primary'><span class='glyphicon glyphicon-download'></span> Export CSV</a> ";
            $str .= "</td>";
        } else {
            $str .= "<td colspan='2' class='col-sm-4'>";
            $str .= "<div class='alert alert-warning'>".$resultCount["msg"]."</div>";
            $str .= "</td>";
            $tableExists = false;
        }

        $str .= "<td class='col-sm-5'>";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=remove#actions' class='btn btn-danger".($tableExists ? "" : " disabled")."'><span class='glyphicon glyphicon-remove'></span> remove table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=truncate#actions' class='btn btn-danger".($tableExists ? "" : " disabled")."''><span class='glyphicon glyphicon-trash'></span> truncate table</a> ";
        $str .= " <a href='/admin/?section=module_settings&module={$module}&module_table=".$tableInfo["name"]."&table_action=create#actions' class='btn btn-warning".($tableExists ? " disabled" : "")."''><span class='glyphicon glyphicon-plus'></span> create table</a> ";
        $str .= "</td>";
    }
    $str .= "</table>";
    if (empty($objModule->tables)) {
        $str .= "<div class='alert alert-warning'>No tables found for this module</div>";
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
        $module = $_GET["module_reinstall"];

        $result = msv_reinstall_module($module, false);
        if ($result) {
            msv_message_ok("Update module '$module' successful");
        } else {
            msv_message_error("Update failed for module '$module'");
        }
    }

    if (!empty($_GET["table_action"])) {
        // TODO: check $_GET["module"]
        // TODO: check $_GET["table"]

        $result = array();
        $table = $_GET["module_table"];
        $module = $_GET["module"];

        if ($_GET["table_action"] === "create") {

            $result = db_create_table($table);

        } elseif ($_GET["table_action"] === "truncate") {

            $result = db_empty_table($table);

        } elseif ($_GET["table_action"] === "remove") {

            $result = db_remove_table($table);

        }

        if (!empty($result)) {
            if ($result["ok"]) {
                msv_redirect("/admin/?section=module_settings&module=$module&msg=".$result["msg"]);
            } else {
                msv_message_error($result["msg"]);
            }
        }

    }

    if (!empty($_GET["module_install"])) {
        // TODO: check $_GET["module_install"]
        $module = $_GET["module_install"];

        $result = msv_install_module($module);
        if ($result) {
            msv_message_ok("Install module successful: $module");
        } else {
            msv_message_error("Install fail: $module");
        }
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
