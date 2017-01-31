<?php
$tableInfo = MSV_getTableConfig(TABLE_STRUCTURE);
$tableInfo["fields"]["document_text"] = array(
	"name" => "document_text",
	"type" => "doc",
);
MSV_assignData("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	
    MSV_proccessUpdateTable(TABLE_STRUCTURE, "form_");
	
	// save document
	API_updateDBItem(TABLE_DOCUMENTS, "text", "'".MSV_SQLEscape($_POST["form_document_text"])."'", " `id` = '".(int)$_POST["form_page_document_id"]."'");
	
	// save seo
	$resultQuerySEO = API_getDBItem(TABLE_SEO, "`url` = '".MSV_SQLescape($_POST["form_url"])."'");
	if ($resultQuerySEO["ok"] && !empty($resultQuerySEO["data"])) {
		$rowSEO = $resultQuerySEO["data"];
		$rowSEO["title"] = $_POST["form_seo_title"];
		$rowSEO["description"] = $_POST["form_seo_description"];
		$rowSEO["keywords"] = $_POST["form_seo_keywords"];
		$rowSEO["sitemap"] = $_POST["form_published"] == 1 ? 1:0;
        
		$resultSave = API_updateDBItemRow(TABLE_SEO, $rowSEO);
        // вносим коррективы в URL меню 
           $sqlCode = "update `".TABLE_MENU."`
                       set `url` = '".MSV_SQLescape($_POST["form_url"])."' 
                       where `structure_id` = '".MSV_SQLescape($_POST["form_id"])."'
                       ";
                  
           $result = API_SQL($sqlCode);
        // вносим коррективы в URL меню 
        
        
        // выключаем/включаем разделы
        
        $resultQueryItem = API_getDBItem(TABLE_STRUCTURE, "`url` = '".MSV_SQLescape($_POST["form_url"])."'");
    	
      
        $parent_url = array();
        if ($resultQueryItem["ok"]) {
    	  $parent_url = GetParentSection($resultQueryItem["data"]["id"]); 
    	} 
        
        if (!empty($parent_url)) {
           foreach ($parent_url as $v=>$k) {
            if (!empty($k)) {
            
             $sqlCode = "update `".TABLE_STRUCTURE."`
                       set `published` = '".MSV_SQLescape($_POST["form_published"])."' 
                       where `url` = '".$k."'
                       ";
             $result = API_SQL($sqlCode);
               
             $sqlCode = "update `".TABLE_SEO."`
                       set `sitemap` = '".MSV_SQLescape($_POST["form_published"])."' 
                       where `url` like '".$k."%'
                       ";
             $result = API_SQL($sqlCode);
             }            
           }
        }
        
		// выключаем/включаем разделы/подразделы
        
        API_SiteMapGenegate(); // генерируем карту сайта
	} else {
		$resultSave = SEO_add($_POST["form_url"], $_POST["form_seo_title"], $_POST["form_seo_description"], $_POST["form_seo_keywords"],($_POST["form_published"] == 1 ? 1:0));
        if ($_POST["form_published"] == 1) {
            API_SiteMapGenegate();
        }
	}
	if (!$resultSave["ok"]) {
		MSV_redirect("/admin/?section=$section&edit=".$_POST["form_id"]."&save_error=".urlencode($resultSave["msg"]));
        
	}
}


function GetParentSection($id) {
      $parent_url = array();
      $result = API_getDBList(TABLE_STRUCTURE, "`parent_id`='".$id."'","",1000);
      if ($result["ok"]) {
          foreach ($result["data"] as $row) {
            $parent_url[] = $row['url'];
            $parent_url = array_merge($parent_url, GetParentSection($row['id']));
          }
      }    
      return $parent_url;  
}


if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["form_id"];
}
if (!empty($_REQUEST["edit"])) {
	$resultQueryItem = API_getDBItem(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["edit"]."'");
	if ($resultQueryItem["ok"]) {
		$editStructure = $resultQueryItem["data"];
		
		if (!empty($editStructure["page_document_id"])) {
			$resultQueryDocument = API_getDBItem(TABLE_DOCUMENTS, "`id` = '".(int)$editStructure["page_document_id"]."'");
			if ($resultQueryDocument["ok"]) {
				$editStructure["document_text"] = $resultQueryDocument["data"]["text"];
			}
		}
		
		$resultQuerySEO = API_getDBItem(TABLE_SEO, "`url` = '".MSV_SQLescape($editStructure["url"])."'");
		if ($resultQuerySEO["ok"]) {
			$editStructure["seo_title"] = $resultQuerySEO["data"]["title"];
			$editStructure["seo_description"] = $resultQuerySEO["data"]["description"];
			$editStructure["seo_keywords"] = $resultQuerySEO["data"]["keywords"];
		}
		
		MSV_assignData("admin_edit_structure", $editStructure);
	}
}
if (!empty($_REQUEST["duplicate"])) {
	$resultQueryItem = API_getDBItem(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["duplicate"]."'");
	if ($resultQueryItem["ok"]) {
		$resultQueryItem["data"]["id"] = "";
		$resultQueryItem["data"]["page_document_id"] = "";
		MSV_assignData("admin_edit_structure", $resultQueryItem["data"]);
		
		// TODO:
		// do something with document_text.
		// it will not be saved
	}
}
if (!empty($_REQUEST["add_child"])) {
	$resultQueryItem = API_getDBItem(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["add_child"]."'");
	if ($resultQueryItem["ok"]) {
		$resultQueryItem["data"]["parent_id"] = $resultQueryItem["data"]["id"];
		$resultQueryItem["data"]["url"] = $resultQueryItem["data"]["url"]."new-page/";
		$resultQueryItem["data"]["id"] = "";
		
		MSV_assignData("admin_edit_structure", $resultQueryItem["data"]);
	}
}
if (!empty($_REQUEST["delete"])) {
	$resultQueryDelete = API_deleteDBItem(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["delete"]."'");
	MSV_MessageOK(_t("msg.deleted_ok"));
}
if (isset($_REQUEST["add_new"])) {
	$item = array("id" => "", "published" => 1, "deleted" => 0);
	if (!empty($_REQUEST["edit_key"])) {
		$item["id"] = $_REQUEST["edit_key"];
	}
	MSV_assignData("admin_edit_structure", $item);
}
if (!empty($_REQUEST["document_create"])) {
	$resultQueryItem = API_getDBItem(TABLE_STRUCTURE, "`id` = '".(int)$_REQUEST["document_create"]."'");
	if ($resultQueryItem["ok"]) {
		
		$structure_id = $resultQueryItem["data"]["id"];
		$name = $resultQueryItem["data"]["name"];
		$resultDocument = MSV_Document_add($name, "", "");
		
		// update structure=>set document
		if ($resultDocument["ok"]) {
			API_updateDBItem(TABLE_STRUCTURE, "page_document_id", $resultDocument["insert_id"], " id = '".$structure_id."'");
		}
		MSV_MessageOK(_t("msg.created_ok"));
	}
}


if (!empty($_REQUEST["sort"])) {
	// TODO: check if correct key
	$sort = $_REQUEST["sort"];
} else {
	$sort = "parent_id";
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



// Load list of items
$resultQuery = API_getDBListPaged(TABLE_STRUCTURE, "", "`$sort` $sortd", 100, "p");
if ($resultQuery["ok"]) {
	$adminList = $resultQuery["data"];
	$listPages = $resultQuery["pages"];
	MSV_assignData("admin_list_pages", $listPages);

	foreach ($tableInfo["fields"] as $field) {
		
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
				
				if (!empty($listItem[$field["name"]])) {
					$listItem[$field["name"]."_data"] = $field["data"][$listItem[$field["name"]]];
				}
				
				$adminListFiltered[$listItemID] = $listItem;
			}
			$adminList = $adminListFiltered;
		}
	}
	
	MSV_assignData("admin_list", $adminList);
}


