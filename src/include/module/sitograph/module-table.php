<?php
if (empty($table)) {
	return false;
}
if (empty($section)) {
	return false;
}

$tableInfo = MSV_getTableConfig($table);
MSV_assignData("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	$result = MSV_proccessUpdateTable($table, "form_");
	if ($result["ok"]) {
		
		// update SEO
		if ($tableInfo["useseo"]) {
			// make item Url
			$itemUrl = $sectionObj->baseUrl.$_POST["form_url"];
			if (FORSE_TRAILING_SLASH) {
				$itemUrl .= "/";
			}
			
			// save seo
			$resultQuerySEO = API_getDBItem(TABLE_SEO, "`url` = '".MSV_SQLescape($itemUrl)."'");
			if ($resultQuerySEO["ok"] && !empty($resultQuerySEO["data"])) {
				$rowSEO = $resultQuerySEO["data"];
				$rowSEO["title"] = $_POST["form_seo_title"];
				$rowSEO["description"] = $_POST["form_seo_description"];
				$rowSEO["keywords"] = $_POST["form_seo_keywords"];
                $rowSEO["sitemap"] = $_POST["form_published"] == 1 ? 1:0;
				
				$resultSave = API_updateDBItemRow(TABLE_SEO, $rowSEO);
                MSV_SitemapGenegate();
			} else {
				$resultSave = SEO_add($itemUrl, $_POST["form_seo_title"], $_POST["form_seo_description"], $_POST["form_seo_keywords"],($_POST["form_published"] == 1 ? 1:0));
                if ($_POST["form_published"] == 1) {
                    MSV_SitemapGenegate();
                }
			}
		}
	} else {
		MSV_redirect("/admin/?section=$section&table=$admin_table&save_error=".$result["msg"]);
	}
}
if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["form_id"];
}
if (!empty($_REQUEST["edit"])) {
	$resultQueryItem = API_getDBItem($table, "`id` = '".(int)$_REQUEST["edit"]."'");
	if ($resultQueryItem["ok"]) {
		
		// make item Url
		$itemUrl = $sectionObj->baseUrl.$resultQueryItem["data"]["url"];
		if (FORSE_TRAILING_SLASH) {
			$itemUrl .= "/";
		}
		
		// get item SEO
		$resultQuerySEO = API_getDBItem(TABLE_SEO, "`url` = '".MSV_SQLescape($itemUrl)."'");
		if ($resultQuerySEO["ok"]) {
			$resultQueryItem["data"]["seo_title"] = $resultQuerySEO["data"]["title"];
			$resultQueryItem["data"]["seo_description"] = $resultQuerySEO["data"]["description"];
			$resultQueryItem["data"]["seo_keywords"] = $resultQuerySEO["data"]["keywords"];
		}
		
		MSV_assignData("admin_edit", $resultQueryItem["data"]);
	}
}
if (!empty($_REQUEST["duplicate"])) {
	$resultQueryItem = API_getDBItem($table, "`id` = '".(int)$_REQUEST["duplicate"]."'");
	if ($resultQueryItem["ok"]) {
		$resultQueryItem["data"]["id"] = "";
		MSV_assignData("admin_edit", $resultQueryItem["data"]);
	}
}
if (!empty($_REQUEST["delete"])) {
	$resultQueryDelete = API_deleteDBItem($table, "`id` = '".(int)$_REQUEST["delete"]."'");
	MSV_MessageOK(_t("msg.deleted_ok"));
}
if (isset($_REQUEST["add_new"])) {
	$item = array(
		"id" => "", 
		"published" => 1, 
		"deleted" => 0,
		"lang" => LANG,
	);
	if (!empty($_REQUEST["edit_key"])) {
		// toDO: ket from table config
		//$item["id"] = $_REQUEST["edit_key"];
	}
	MSV_assignData("admin_edit", $item);
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
	$sortd = "asc";
	$sortd_rev = "desc";
}

MSV_assignData("table_sort", $sort);
MSV_assignData("table_sortd", $sortd);
MSV_assignData("table_sortd_rev", $sortd_rev);


$resultQuery = API_getDBListPaged($table, "", "`$sort` $sortd", 100, "p");
if ($resultQuery["ok"]) {
	MSV_assignData("admin_list", $resultQuery["data"]);
	
	$adminList = $resultQuery["data"];
	$listPages = $resultQuery["pages"];
	MSV_assignData("admin_list_pages", $listPages);
	
	$adminListSkipFields = array();
	$adminListSkipFields[] = "deleted";
	$adminListSkipFields[] = "published";
	$adminListSkipFields[] = "author";
	$adminListSkipFields[] = "updated";

	foreach ($tableInfo["fields"] as $field) {
		if($field["listskip"] > 0) {
			$adminListSkipFields[] = $field["name"];
		}
				
		if (!empty($field["select-from"])) {
			$field["type"] = "select";
			
			if ($field["select-from"]["source"] === "table") {
				$cfg = MSV_getTableConfig($field["select-from"]["name"]);
				// TODO: multi index support
				// index from config?
				$index = "id";
				$title = $cfg["title"];
				
				$queryData = API_getDBList($field["select-from"]["name"], "", "`$title` asc");
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
	
	MSV_assignData("admin_list_skip", $adminListSkipFields);
	MSV_assignData("admin_list", $adminList);
}
