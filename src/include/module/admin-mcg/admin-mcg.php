<?php
include(ABS_MODULE."/admin-mcg/config-menu.php");

MSV_IncludeJSFile("/content/js/admin.js");
MSV_IncludeJSFile("/content/js/admin-mcg.js");
 
if ($this->website->requestUrl === $this->activationUrl) {

	//var_dump($this->website->requestUrl);

}
$cms_icon = MSV_getConfig("admin_cms_icon");
if (empty($cms_icon)) {
	MSV_assignData("admin_cms_icon", "cms_favicon.gif");
}

MSV_assignData("admin_title", $this->info." v.".$this->version);

$section = "index";
if (!empty($_REQUEST["section"])) {
	$section = $_REQUEST["section"];
}
// pagination
if (!empty($_REQUEST["p"])) {
    $admin_list_page = $_REQUEST["p"];
    MSV_assignData("admin_list_page", $_REQUEST["p"]);
} else {
    $admin_list_page = 0;
}

MSV_assignData("admin_menu", $menu_ar);



if (!empty($section) && array_key_exists($section, $menu_ar)) {
	$menuItem = $menu_ar[$section];
	$menuItem["id"] = $section;
	
	$admin_table = $menuItem["table"];
	if (!empty($_REQUEST["table"])) {
		//die;
		$admin_table = $_REQUEST["table"];
		// TODO: check input
		$menuItem["table"] = $admin_table;
	}

	$menuItemInfo = $menuItem;
	if (!empty($admin_table)) {
		foreach ($menu_ar as $menuItemID => $item) {
			if (!is_array($item["submenu"])) continue;
			
			if (array_key_exists($admin_table, $item["submenu"])) {
				$menuActive = $menuItemID;
				$menuSubActive = $admin_table;
				$menuItemInfo = $item["submenu"][$admin_table];
			}
		}
	}

	MSV_assignData("admin_info", $menuItem);
	MSV_assignData("admin_section", $section);
	MSV_assignData("admin_table", $admin_table);
	MSV_assignData("admin_menu_item", $menuItemInfo);
	
	
	// get module object
	$sectionObj = MSV_get("website.$section");
	
	$handler = $menuItem["handler"];
	
	if (!empty($handler)) {
		$handlerPath = ABS_MODULE."/admin-mcg/".$handler;
		if (file_exists($handlerPath)) {
			$table = $menuItem["table"];
			include($handlerPath);
		} else {
			MSV_MessageError("Module handler not found <b>$handler</b>");
		}
	}
	if (!empty($_POST["save_exit"])) {
		MSV_redirect("/admin/?section=$section&table=$admin_table&saved&p=".$admin_list_page);
	}
	if (!empty($_POST["save"])) {
		MSV_MessageOK(_t("msg.saved_ok"));
	}
	if (isset($_GET["saved"])) {
		MSV_MessageOK(_t("msg.saved_ok"));
	}
	if (!empty($_GET["save_error"])) {
		MSV_MessageError(_t("msg.save_error").": ".$_GET["save_error"]);
	}
	

	if (!empty($_REQUEST["edit"]) || !empty($_REQUEST["duplicate"]) || !empty($_REQUEST["add_child"]) || isset($_REQUEST["add_new"])) {
		$table_edit = MSV_getConfig("admin_edit");
		
		$tabs = array();
		$tabs["home"] = array("title" => _t("tab.home"), "fields" => array());
		$tabs["document"] = array("title" => _t("tab.document"), "fields" => array());
		$tabs["seo"] = array("title" => _t("tab.seo"), "fields" => array());
		$tabs["files"] = array("title" => _t("tab.files"), "fields" => array());
		$tabs["access"] = array("title" => _t("tab.access"), "fields" => array());
		$tabs["history"] = array("title" => _t("tab.history"), "fields" => array());
		
		$table_info = MSV_getConfig("admin_table_info");
		if (!empty($table_info)) {
			
			if ($table_info["useseo"]) {
				$infoSEO = MSV_getTableConfig(TABLE_SEO);
				
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
				if (!empty($field["select-from"])) {
					//$field["type"] = "select";

					if ($field["select-from"]["source"] === "table") {
						
						$cfg = MSV_getTableConfig($field["select-from"]["name"]);
						// TODO: multi index support
						// index from config?
						$index = "id";
						$title = $cfg["title"];
						$filter = $field["select-from"]["filter"];
						$order = $field["select-from"]["order"];
						if (empty($order)) {
							$order = "`$title` asc";
						}
						
						$queryData = API_getDBList($field["select-from"]["name"], $filter, $order);
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
				
				if ($field["type"] === "doc") {
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
				 || $field["type"] === "array"
				 || $field["type"] === "multiselect"
				 || $field["type"] === "select"
				 || $field["type"] === "select") {
					$tabs["home"]["fields"][] = $field;
				} else {	// TODO: ? do we need this?
					$tabs["home"]["fields"][] = $field;
				}
			}
		}
		MSV_assignData("admin_edit_tabs", $tabs);
		MSV_assignData("admin_edit", $table_edit);
	}
	
	
	if (isset($_GET["export"])) {
		header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename='.$table.'-'.time().'.csv');
	
		$out = fopen('php://output', 'w');
		
		$table_info = MSV_getConfig("admin_table_info");
		$rowShort = array();
		foreach ($table_info["fields"] as $field) {
			if (!in_array($field["name"], $adminListSkipFields)) {
				$rowShort[] = _t("table.".$table_info["name"].".".$field["name"]);
			}
		}
		fputcsv($out, $rowShort);
		
		
		foreach ($adminList as $row) {
			$rowShort = array();
			
			foreach ($row as $k => $v) {
				if (!in_array($k, $adminListSkipFields)) {
					$rowShort[] = $v;
				}
			}
			fputcsv($out, $rowShort);
		}
		
		fclose($out);
		die;
	}
	
}



function AdminMCGInstall() {
	// update admin pages
	MSV_Structure_add("*", "/admin/", "Admin Homepage", "default", "admin-mcg.tpl", 0, "", 0, "admin");
	MSV_Structure_add("*", "/admin/login/", "Admin Homepage Login", "default", "admin-mcg-login.tpl", 0, "", 0, "everyone");
}


