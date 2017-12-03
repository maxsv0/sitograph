<?php
$tableInfo = msv_get_config_table(TABLE_STRUCTURE);
$tableInfo["fields"]["document_name"] = array(
    "name" => "document_name",
    "type" => "text",
);
$tableInfo["fields"]["document_text"] = array(
    "name" => "document_text",
    "type" => "doc",
);
msv_assign_data("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
    $resultSave = msv_process_updatetable(TABLE_STRUCTURE, "form_");

    if ($resultSave["ok"]) {
        // save document
        db_update(TABLE_DOCUMENTS, "text", "'" . db_escape($_POST["form_document_text"]) . "'", " `id` = '" . (int)$_POST["form_page_document_id"] . "'");
        db_update(TABLE_DOCUMENTS, "name", "'" . db_escape($_POST["form_document_name"]) . "'", " `id` = '" . (int)$_POST["form_page_document_id"] . "'");

        // save seo
        $resultQuerySEO = db_get(TABLE_SEO, "`url` = '" . db_escape($_POST["form_url"]) . "'");
        if ($resultQuerySEO["ok"] && !empty($resultQuerySEO["data"])) {
            $rowSEO = $resultQuerySEO["data"];
            $rowSEO["title"] = $_POST["form_seo_title"];
            $rowSEO["description"] = $_POST["form_seo_description"];
            $rowSEO["keywords"] = $_POST["form_seo_keywords"];
            $rowSEO["sitemap"] = $_POST["form_published"] == 1 ? 1 : 0;

            $resultSave = db_update_row(TABLE_SEO, $rowSEO);
            ///
            ///
            $sqlCode = "update `" . TABLE_MENU . "`
               set `url` = '" . db_escape($_POST["form_url"]) . "'
               where `structure_id` = '" . db_escape($_POST["form_id"]) . "'
               ";

            $result = db_sql($sqlCode);

            $resultQueryItem = db_get(TABLE_STRUCTURE, "`url` = '" . db_escape($_POST["form_url"]) . "'");


            $parent_url = array();
            if ($resultQueryItem["ok"]) {
                $parent_url = GetParentSection($resultQueryItem["data"]["id"]);
            }

            if (!empty($parent_url)) {
                foreach ($parent_url as $v => $k) {
                    if (!empty($k)) {
                        $sqlCode = "update `" . TABLE_STRUCTURE . "`
                               set `published` = '" . db_escape($_POST["form_published"]) . "'
                               where `url` = '" . $k . "'
                               ";
                        $result = db_sql($sqlCode);

                        $sqlCode = "update `" . TABLE_SEO . "`
                               set `sitemap` = '" . db_escape($_POST["form_published"]) . "'
                               where `url` like '" . $k . "%'
                               ";
                        $result = db_sql($sqlCode);
                    }
                }
            }

            msv_genegate_sitemap(true);
        } else {
            // extract data from request for corresponding table
            $item = msv_process_tabledata(TABLE_SEO, "form_seo_");
            $item["url"] = $_POST["form_url"];

            // execute request
            $resultSave = msv_add_seo($item);
            if ($_POST["form_published"] == 1) {
                msv_genegate_sitemap(true);
            }
        }
    } else {
        msv_redirect("/admin/?section=$section&edit=".$_POST["form_id"]."&save_error=".urlencode($resultSave["msg"]));
    }
}

if (!empty($_POST["save"])) {
    $_REQUEST["edit"] = $_POST["form_id"];
}

if (!empty($_REQUEST["edit"])) {
    $resultQueryItem = db_get(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["edit"]."'");
    if ($resultQueryItem["ok"]) {
        $editStructure = $resultQueryItem["data"];

        if (!empty($editStructure["page_document_id"])) {
            $resultQueryDocument = db_get(TABLE_DOCUMENTS, "`id` = '".(int)$editStructure["page_document_id"]."'");
            if ($resultQueryDocument["ok"]) {
                $editStructure["document_text"] = $resultQueryDocument["data"]["text"];
            }
        }

        $resultQuerySEO = db_get(TABLE_SEO, "`url` = '".db_escape($editStructure["url"])."'");
        if ($resultQuerySEO["ok"]) {
            $editStructure["seo_title"] = $resultQuerySEO["data"]["title"];
            $editStructure["seo_description"] = $resultQuerySEO["data"]["description"];
            $editStructure["seo_keywords"] = $resultQuerySEO["data"]["keywords"];
        }

        msv_assign_data("admin_edit_structure", $editStructure);
    }
}

if (!empty($_REQUEST["duplicate"])) {
    $resultQueryItem = db_get(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["duplicate"]."'");
    if ($resultQueryItem["ok"]) {
        $resultQueryItem["data"]["id"] = "";
        $resultQueryItem["data"]["page_document_id"] = "";
        msv_assign_data("admin_edit_structure", $resultQueryItem["data"]);

        // TODO:
        // do something with document_text.
        // it will not be saved
    }
}

if (!empty($_REQUEST["add_child"])) {
    $resultQueryItem = db_get(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["add_child"]."'");
    if ($resultQueryItem["ok"]) {
        $resultQueryItem["data"]["parent_id"] = $resultQueryItem["data"]["id"];
        $resultQueryItem["data"]["url"] = $resultQueryItem["data"]["url"]."new-page/";
        $resultQueryItem["data"]["id"] = "";
        $resultQueryItem["data"]["page_document_id"] = "";

        msv_assign_data("admin_edit_structure", $resultQueryItem["data"]);
    }
}

if (!empty($_REQUEST["delete"])) {
    $resultQueryDelete = db_delete(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["delete"]."'");
    msv_message_ok(_t("msg.deleted_ok"));
}

if (isset($_REQUEST["add_new"])) {
    $item = array("id" => "", "published" => 1, "deleted" => 0);
    if (!empty($_REQUEST["edit_key"])) {
        $item["id"] = $_REQUEST["edit_key"];
    }
    msv_assign_data("admin_edit_structure", $item);
}

if (!empty($_REQUEST["document_create"])) {
    $resultQueryItem = db_get(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["document_create"]."'");
    if ($resultQueryItem["ok"]) {
        $structure_id = $resultQueryItem["data"]["id"];
        $name = $resultQueryItem["data"]["name"];
        $resultDocument = msv_add_document(array("name" => $name));

        // update structure=>set document
        if ($resultDocument["ok"]) {
            db_update(TABLE_STRUCTURE, "page_document_id", $resultDocument["insert_id"], " id = '".$structure_id."'");
        }
        msv_message_ok(_t("msg.created_ok"));
    }
    $_REQUEST["edit"] = $_REQUEST["document_create"];
}

if (!empty($_REQUEST["edit"])) {
    $resultQueryItem = db_get(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["edit"]."'");
    if ($resultQueryItem["ok"]) {
        $editStructure = $resultQueryItem["data"];

        if (!empty($editStructure["page_document_id"])) {
            $resultQueryDocument = db_get(TABLE_DOCUMENTS, "`id` = '".(int)$editStructure["page_document_id"]."'");
            if ($resultQueryDocument["ok"]) {
                $editStructure["document_text"] = $resultQueryDocument["data"]["text"];
                $editStructure["document_name"] = $resultQueryDocument["data"]["name"];
            }
        }

        $resultQuerySEO = db_get(TABLE_SEO, "`url` = '".db_escape($editStructure["url"])."'");
        if ($resultQuerySEO["ok"]) {
            $editStructure["seo_title"] = $resultQuerySEO["data"]["title"];
            $editStructure["seo_description"] = $resultQuerySEO["data"]["description"];
            $editStructure["seo_keywords"] = $resultQuerySEO["data"]["keywords"];
        }

        msv_assign_data("admin_edit_structure", $editStructure);
    }
}

if (!empty($_REQUEST["sort"])) {
    // TODO: check if correct key
    $sort = $_REQUEST["sort"];
} else {
    $sort = "url";
}

if (!empty($_REQUEST["sortd"])) {
    if ($_REQUEST["sortd"] === "desc") {
        $sortd = "desc";
        $sortd_rev = "asc";
    } else {
        $sortd = "asc";
        $sortd_rev = "desc";
    }
} else {
    $sortd = "asc";
    $sortd_rev = "desc";
}

msv_assign_data("table_sort", $sort);
msv_assign_data("table_sortd", $sortd);
msv_assign_data("table_sortd_rev", $sortd_rev);

// Load list of items
$resultQuery = db_get_list(TABLE_STRUCTURE, "", "`$sort` $sortd", 1000, "p");
if ($resultQuery["ok"]) {
    $adminList = $resultQuery["data"];
    $listPages = $resultQuery["pages"];
    msv_assign_data("admin_list_pages", $listPages);

    foreach ($tableInfo["fields"] as $field) {

        if (!empty($field["select-from"])) {
            $field["type"] = "select";

            if ($field["select-from"]["source"] === "table") {
                $cfg = msv_get_config_table($field["select-from"]["name"]);
                // TODO: multi index support
                // index from config?
                $index = "id";
                $title = $cfg["title"];

                $queryData = db_get_list($field["select-from"]["name"], "", "`$title` asc");
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

            $adminListFiltered = array();
            foreach ($adminList as $listItemID => $listItem) {

                if (!empty($listItem[$field["name"]])) {
                    $listItem[$field["name"]."_data"] = $field["data"][$listItem[$field["name"]]];
                }
                $adminListFiltered[$listItemID] = $listItem;
            }
            $adminList = $adminListFiltered;
        }
    }

    $adminListFiltered = array();
    foreach ($adminList as $listItemID => $listItem) {
        if (isset($listItem['parent_id'])) {
            $adminListFiltered[$listItem['parent_id']][] = $listItem;
        }
    }
    $adminList = $adminListFiltered;
    msv_assign_data("admin_list", $adminList);

    if (!empty($_SESSION['structure_show'])) msv_assign_data("structure_show", $_SESSION['structure_show']);
}


function GetParentSection($id) {
    $parent_url = array();
    $result = db_get_list(TABLE_STRUCTURE, "`parent_id`='".$id."'","",1000);
    if ($result["ok"]) {
        foreach ($result["data"] as $row) {
            $parent_url[] = $row['url'];
            $parent_url = array_merge($parent_url, GetParentSection($row['id']));
        }
    }
    return $parent_url;
}



function ajax_set_structure_status ($module) {

    if (!empty($_REQUEST['mode'])) {
        if ($_REQUEST['mode'] == 'add') {
            $_SESSION['structure_show'][$_REQUEST['index']] = $_REQUEST['level'];
        } elseif($_REQUEST['mode'] == 'remove') {
            unset($_SESSION['structure_show'][$_REQUEST['index']]);
        }
    }

    $result['ok'] =true;
    return json_encode($result);
}