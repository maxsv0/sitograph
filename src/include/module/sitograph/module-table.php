<?php
if (empty($table)) {
	return false;
}
if (empty($section)) {
	return false;
}

$tableInfo = msv_get_config_table($table);
msv_assign_data("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	$result = msv_process_updatetable($table, "form_");
	if ($result["ok"]) {

		// update SEO
		if ($tableInfo["useseo"]) {
			// make item Url
			$itemUrl = $sectionObj->baseUrl.$_POST["form_url"];
			$itemUrl .= "/";

			// save seo
			$resultQuerySEO = db_get(TABLE_SEO, "`url` = '".db_escape($itemUrl)."'");
			if ($resultQuerySEO["ok"] && !empty($resultQuerySEO["data"])) {
				$rowSEO = $resultQuerySEO["data"];
				$rowSEO["title"] = $_POST["form_seo_title"];
				$rowSEO["description"] = $_POST["form_seo_description"];
				$rowSEO["keywords"] = $_POST["form_seo_keywords"];
                $rowSEO["sitemap"] = $_POST["form_published"] == 1 ? 1:0;

				$resultSave = db_update_row(TABLE_SEO, $rowSEO);
                msv_genegate_sitemap(true);
			} else {
                // extract data from request for corresponding table
                $item = msv_process_tabledata(TABLE_SEO, "form_seo_");

                // execute request
                $resultSave = msv_add_seo($item);

                if ($_POST["form_published"] == 1) {
                    msv_genegate_sitemap(true);
                }
			}
		}
	} else {
	    if (!empty($_REQUEST["ajaxcall"])) {
            msv_redirect("/admin/?ajaxcall=1&section=$section&table=$admin_table&save_error=".$result["msg"]);
        } else {
            msv_redirect("/admin/?section=$section&table=$admin_table&save_error=".$result["msg"]);
        }

	}
}
if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["form_id"];
}
if (!empty($_REQUEST["edit_key"])) {
	$resultQueryItem = db_get($table, "`param` like '".db_escape($_REQUEST["edit_key"])."'");
	if ($resultQueryItem["ok"] && !empty($resultQueryItem["data"])) {
		$_REQUEST["edit"] = $resultQueryItem["data"]["id"];
	} else {
		$_REQUEST["add_new"] = 1;
	}
}
if (!empty($_REQUEST["edit"])) {
	$resultQueryItem = db_get($table, "`id` = '".(int)$_REQUEST["edit"]."'");
	if ($resultQueryItem["ok"]) {

		// make item Url
		$itemUrl = $sectionObj->baseUrl.$resultQueryItem["data"]["url"];
		$itemUrl .= "/";

		// get item SEO
		$resultQuerySEO = db_get(TABLE_SEO, "`url` = '".db_escape($itemUrl)."'");
		if ($resultQuerySEO["ok"]) {
			$resultQueryItem["data"]["seo_title"] = $resultQuerySEO["data"]["title"];
			$resultQueryItem["data"]["seo_description"] = $resultQuerySEO["data"]["description"];
			$resultQueryItem["data"]["seo_keywords"] = $resultQuerySEO["data"]["keywords"];
		}

        msv_assign_data("admin_edit", $resultQueryItem["data"]);
	}
}
if (!empty($_REQUEST["duplicate"])) {
	$resultQueryItem = db_get($table, "`id` = '".(int)$_REQUEST["duplicate"]."'");
	if ($resultQueryItem["ok"]) {
		$resultQueryItem["data"]["id"] = "";
        msv_assign_data("admin_edit", $resultQueryItem["data"]);
	}
}
if (!empty($_REQUEST["delete"])) {
	$resultQueryDelete = db_delete($table, "`id` = '".(int)$_REQUEST["delete"]."'");
    msv_message_ok(_t("msg.deleted_ok"));
}
if (isset($_REQUEST["add_new"])) {
	$item = array(
		"id" => "",
		"published" => 1,
		"deleted" => 0,
		"lang" => LANG,
	);
	if (!empty($_REQUEST["edit_key"])) {
		// toDO: support multi index
		$item[$tableInfo["index"]] = $_REQUEST["edit_key"];
	}
    msv_assign_data("admin_edit", $item);
}

if (!empty($_REQUEST["sort"])) {
	// TODO: check if correct key
	$sort = $_REQUEST["sort"];
} else {
	$sort = "id";
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
	$sortd = "desc";
	$sortd_rev = "asc";
}

$listLimit = 100;

msv_assign_data("table_sort", $sort);
msv_assign_data("table_sortd", $sortd);
msv_assign_data("table_sortd_rev", $sortd_rev);
msv_assign_data("table_limit", $listLimit);

$resultQuery = db_get_listpaged($table, "", "`$sort` $sortd", $listLimit, "p");
if ($resultQuery["ok"]) {
    msv_assign_data("admin_list", $resultQuery["data"]);

	$adminList = $resultQuery["data"];
	$listPages = $resultQuery["pages"];
    msv_assign_data("admin_list_pages", $listPages);

	$adminListSkipFields = $adminListFields = array();
	$adminListSkipFields[] = "deleted";
	$adminListSkipFields[] = "published";
	$adminListSkipFields[] = "author";
	$adminListSkipFields[] = "updated";

	foreach ($tableInfo["fields"] as $field) {
        if (!in_array($field["name"], $adminListFields)) {
            $adminListFields[] = $field["name"];
        }

		if($field["listskip"] > 0) {
			$adminListSkipFields[] = $field["name"];
		}

		if (!empty($field["select-from"])) {
			$field["type"] = "select";

			if ($field["select-from"]["source"] === "table") {
				$cfg = msv_get_config_table($field["select-from"]["name"]);
				// TODO: multi index support
				$index = $cfg["index"];
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

				if (is_array($listItem[$field["name"]])) {

					$str = "";
					foreach ($listItem[$field["name"]] as $value) {
						$str .=  $field["data"][$value].",";
					}
					$listItem[$field["name"]] = substr($str, 0, -1);

				} elseif (!empty($listItem[$field["name"]])) {
					$listItem[$field["name"]."_data"] = $listItem[$field["name"]];
					$listItem[$field["name"]] = $field["data"][$listItem[$field["name"]]];
				}

				$adminListFiltered[$listItemID] = $listItem;
			}
			$adminList = $adminListFiltered;
		}
	}

    msv_assign_data("admin_list_skip", $adminListSkipFields);
    msv_assign_data("admin_list_fields", $adminListFields);
    msv_assign_data("admin_list", $adminList);
}
