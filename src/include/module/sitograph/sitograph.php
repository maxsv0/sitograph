<?php
if (!msv_check_accessuser("admin")) {
    return;
}

// include JS for inline edit
$edit_mode = msv_get_config("edit_mode");
if ($edit_mode) {
    msv_include_jsfile("/content/js/sitograph.js");
}

include(ABS_MODULE."/sitograph/config-menu.php");
msv_assign_data("admin_menu", $menu_ar);

msv_assign_data("admin_title", $this->title." ".$this->version." <small>".$this->date."</small>");
msv_assign_data("admin_title_page", $this->description." ".$this->version."");

$section = "index";
$menuActive = "index";
$menuSubActive = "realtime";

if (!empty($_REQUEST["section"])) {
    $section = $_REQUEST["section"];
}

if (!empty($_REQUEST["table"])) {
    $admin_table = $_REQUEST["table"];
}

// pagination
if (!empty($_REQUEST["p"])) {
    $admin_list_page = $_REQUEST["p"];
} else {
    $admin_list_page = 0;
}
msv_assign_data("admin_list_page", $admin_list_page);

$menuItem = array();
$menuActive = $menuSubActive = "";

if (!empty($section)) {
    if (array_key_exists($section, $menu_ar)) {
        $menuItem = $menu_ar[$section];
        $menuActive = $section;
    } else {
        foreach ($menu_ar as $menuItemID => $item) {
            if (!is_array($item["submenu"])) continue;

            if (array_key_exists($section, $item["submenu"])) {
                $menuActive = $menuItemID;
                $menuSubActive = $section;
                $menuItem = $item["submenu"][$section];
            }
        }
    }
}

if (!empty($menuItem["table"])) {
    $admin_table = $menuItem["table"];
}

if (!empty($admin_table)) {
    foreach ($menu_ar as $menuItemID => $item) {
        if (!is_array($item["submenu"])) continue;

        if (array_key_exists($admin_table, $item["submenu"])) {
            $menuActive = $menuItemID;
            $menuSubActive = $admin_table;
            $menuItem = $item["submenu"][$admin_table];
        }
    }
}
if (empty($menuSubActive)) {
    $menuSubActive = "index";
}
msv_assign_data("admin_section", $section);
msv_assign_data("admin_menu_active", $menuActive);
msv_assign_data("admin_submenu_active", $menuSubActive);
msv_assign_data("admin_menu_item", $menuItem);
msv_assign_data("admin_table", $admin_table);

if (!empty($menuItem)) {
    $admin_page_title = $menuItem["title"];
    $admin_page_template = $menuItem["file"];
} else {
    $admin_page_title = "";
    $admin_page_template = "";
}

// add pre-defined modules modules
if ($section === "module_search") {
    $handlerPath = ABS_MODULE."/sitograph/module-search.php";
    if (file_exists($handlerPath)) {
        include($handlerPath);
    } else {
        msv_message_error("Search handler not found at path <b>$handlerPath</b>");
    }
    $admin_page_title = "Search Website";
    $admin_page_template = "search.tpl";
} elseif ($section === "export") {
    $handlerPath = ABS_MODULE."/sitograph/export.php";
    if (file_exists($handlerPath)) {
        include($handlerPath);
    } else {
        msv_message_error("Export handler not found at path <b>$handlerPath</b>");
    }
}

msv_assign_data("admin_page_title", $admin_page_title);
msv_assign_data("admin_page_template", $admin_page_template);

if (!empty($section) && in_array($section, $menu_index)) {

    // TODO: remove not needed lines
    // get module object
    $sectionObj = msv_get("website.$section");

    // assign module base url
    msv_assign_data("module_base_url", $sectionObj->baseUrl);

    // set admin section hendler
    $handler = $menuItem["handler"];

    if (!empty($handler)) {
        $handlerPath = ABS_MODULE."/sitograph/".$handler;

        if (file_exists($handlerPath)) {
            $table = $menuItem["table"];
            include($handlerPath);
        } else {
            msv_message_error("Module handler not found <b>$handler</b>");
        }
    }

    if (!empty($_POST["save_exit"])) {
        msv_redirect("/admin/?section=$section&table=$admin_table&saved&p=".$admin_list_page);
    }
    if (!empty($_POST["save"])) {
        if (!msv_has_messages()) {
            msv_message_ok(_t("msg.saved_ok"));
        }
    }
    if (isset($_GET["msg"])) {
        msv_message_ok($_GET["msg"]);
    }
    if (isset($_GET["saved"])) {
        msv_message_ok(_t("msg.saved_ok"));
    }
    if (!empty($_GET["save_error"])) {
        msv_message_error(_t("msg.save_error").": ".$_GET["save_error"]);
    }

    if (true || !empty($_REQUEST["edit"]) || !empty($_REQUEST["duplicate"]) || !empty($_REQUEST["add_child"]) || isset($_REQUEST["add_new"])) {
        $table_edit = msv_get_config("admin_edit");
        $tabs = msv_get_config("admin_edit_tabs");

        if (empty($tabs)) {
            $tabs = array();
            $tabs["home"] = array("title" => _t("tab.home"), "fields" => array());
            $tabs["document"] = array("title" => _t("tab.document"), "fields" => array());
            $tabs["seo"] = array("title" => _t("tab.seo"), "fields" => array());
            $tabs["files"] = array("title" => _t("tab.files"), "fields" => array());
            $tabs["access"] = array("title" => _t("tab.access"), "fields" => array());
            $tabs["history"] = array("title" => _t("tab.history"), "fields" => array());

            $table_info = msv_get_config("admin_table_info");
            if (!empty($table_info)) {
                if ($table_info["useseo"]) {
                    $infoSEO = msv_get_config_table(TABLE_SEO);

                    $fieldTitle = $infoSEO["fields"]["title"];
                    $fieldTitle["name"] = "seo_title";
                    $fieldDescription = $infoSEO["fields"]["description"];
                    $fieldDescription["name"] = "seo_description";
                    $fieldKeywords = $infoSEO["fields"]["keywords"];
                    $fieldKeywords["name"] = "seo_keywords";

                    $tabs["seo"]["fields"] = array(
                        $fieldTitle,
                        $fieldDescription,
                        $fieldKeywords,
                    );

                }

                foreach ($table_info["fields"] as $field) {
                    $field["title"] = _t("table.".$table_info["name"].".".$field["name"]);

                    if (!empty($field["select-from"])) {
                        if ($field["type"] !== "select" && $field["type"] !== "multiselect") {
                            $field["type"] = "select";
                        }

                        if ($field["select-from"]["source"] === "table") {

                            $cfg = msv_get_config_table($field["select-from"]["name"]);
                            // TODO: multi index support
                            // index from config?
                            $index = $cfg["index"];
                            $title = $cfg["title"];
                            $filter = $field["select-from"]["filter"];
                            $order = $field["select-from"]["order"];
                            if (empty($order)) {
                                $order = "`$title` asc";
                            }

                            $queryData = db_get_list($field["select-from"]["name"], $filter, $order);
                            if ($queryData["ok"]) {
                                $arData = array();
                                foreach ($queryData["data"] as $item) {
                                    $arData[$item[$index]] = $item[$title];
                                }
                                $field["data"] = $arData;
                            }
                        } elseif ($field["select-from"]["source"] === "list") {

                            $field["data"] = array();
                            $list = explode(",", $field["select-from"]["name"]);
                            foreach ($list as $listItem) {
                                $field["data"][$listItem] = _t($field["name"].".".$listItem);
                            }

                        }
                    }

                    if ($field["type"] === "doc" || $field["type"] === "text") {
                        $tabs["document"]["fields"][] = $field;
                    } elseif ($field["type"] === "pic"
                        || $field["type"] === "file") {
                        $tabs["files"]["fields"][] = $field;
                    } elseif ($field["type"] === "published"
                        || $field["type"] === "deleted"
                        || $field["type"] === "author"
                        || $field["type"] === "updated"
                        || $field["type"] === "lang") {
                        $tabs["access"]["fields"][] = $field;
                    } elseif ($field["type"] === "int"
                        || $field["type"] === "id"
                        || $field["type"] === "str"
                        || $field["type"] === "url"
                        || $field["type"] === "array"
                        || $field["type"] === "multiselect"
                        || $field["type"] === "select") {
                        $tabs["home"]["fields"][] = $field;
                    } else {        // TODO: ? do we need this?
                        $tabs["home"]["fields"][] = $field;
                    }
                }
            }
        }

        msv_assign_data("admin_edit_tabs", $tabs);
        msv_assign_data("admin_edit", $table_edit);
    }
}

if (isset($_GET["toggle_edit_mode"])) {
    $edit_mode = msv_get_config("edit_mode");
    if ($edit_mode) {
        msv_set_config("edit_mode", 0, true);
    } else {
        msv_set_config("edit_mode", 1, true);
    }

    $ref = msv_get_config("referer");
    if ($ref) {
        msv_redirect($ref);
    } else {
        msv_redirect("/");
    }
}

$configCMS = msv_get_user_config("cms");
if (empty($configCMS)) {
    $configCMS = array();
}
if (!empty($_REQUEST["admin_favorites"])) {
    if (isset($_REQUEST["admin_favorites_remove"])) {
        unset($configCMS["favorites"][$_REQUEST["admin_favorites"]]);
    } else {
        $configCMS["favorites"][$_REQUEST["admin_favorites"]] = array(
            "url" => $_REQUEST["admin_favorites_url"],
            "text" => $_REQUEST["admin_favorites_text"],
        );
    }
}
msv_set_user_config("cms", $configCMS);
msv_assign_data("config_cms", $configCMS);

if (!empty($admin_table) && !empty($section)) {
    $pageID = $section."_".$admin_table;
    $favoriteUrl = "/admin/?section=$section&table=$admin_table";
} elseif (!empty($section)) {
    $pageID = $section;
    $favoriteUrl = "/admin/?section=$section";
}
msv_assign_data("cms_favorite_id", $pageID);
msv_assign_data("cms_favorite_url", $favoriteUrl);
msv_assign_data("cms_favorite_text", $admin_page_title);

if (!empty($pageID) && 
	!empty($configCMS) && 
	in_array($configCMS["favorites"]) &&
	array_key_exists($pageID, $configCMS["favorites"])) {
    msv_assign_data("cms_favorite_added", 1);
}
