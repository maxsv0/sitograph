<?php
include(ABS_MODULE."/sitograph/config-menu.php");
MSV_assignData("admin_menu", $menu_ar);

MSV_IncludeJSFile("/content/js/sitograph.js");
MSV_IncludeCSSFile("/content/css/sitograph.css");

MSV_assignData("admin_title", $this->title." ".$this->version." <small>".$this->date."</small>");
MSV_assignData("admin_title_page", $this->title." ".$this->description." ".$this->version."");

function AdminLoad($admin) {
	if (DEBUG_PAGE) {
		$admin_notifications_count = 1;
	}
	
	$website = MSV_get("website");
	$website->outputDebug();
	
	$notificationsHtml = $website->config["debug_code"];
	MSV_assignData("admin_notifications_count", $admin_notifications_count);
	MSV_assignData("admin_notifications", $notificationsHtml);
}


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
MSV_assignData("admin_list_page", $admin_list_page);

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

$website = MSV_get("website");

// user with no access will be redirected by MSV class
// but we check access level here to avoid any further file execution
if (!$website->checkAccess($menuItem["access"], $website->user["access"])) {
	return;
}

MSV_assignData("admin_section", $section);
MSV_assignData("admin_menu_active", $menuActive);
MSV_assignData("admin_submenu_active", $menuSubActive);
MSV_assignData("admin_menu_item", $menuItem);
MSV_assignData("admin_table", $admin_table);

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
		MSV_MessageError("Search handler not found at path <b>$handlerPath</b>");
	}
	$admin_page_title = "Search Website";
	$admin_page_template = "search.tpl";
}


MSV_assignData("admin_page_title", $admin_page_title);
MSV_assignData("admin_page_template", $admin_page_template);


if (!empty($section) && in_array($section, $menu_index)) {

	// get module object
	$sectionObj = MSV_get("website.$section");
	
	// set admin section hendler
	$handler = $menuItem["handler"];

	if (!empty($handler)) {
		$handlerPath = ABS_MODULE."/sitograph/".$handler;

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
		
		// TODO: remove this? 
		//MSV_redirect("/admin/?section=$section&table=$admin_table&edit=".$_POST["form_id"]."&saved");
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
					if ($field["type"] !== "select" && $field["type"] !== "multiselect") {
						$field["type"] = "select";
					}

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
		fputs($out, "\xEF\xBB\xBF");
		
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


function SitographInstall($module) {
	MSV_Structure_add("*", "/admin/", _t("structure.admin_homepage"), "default", "sitograph.tpl", 0, "", 0, "admin");
	MSV_Structure_add("*", "/admin/login/", _t("structure.admin_login"), "default", "sitograph-login.tpl", 0, "", 0, "everyone");
	
	// mailing options
	MSV_setConfig("email_from", "tech@sitograph.com", true, "*");
	MSV_setConfig("email_fromname", "Sitograph", true, "*");
	
	// add mail templates
	
	$header = '
<style type="text/css">
* {font-family: Arial, sans-serif; }
strong {color:#bb233a;}
a {color:#bb233a;}
a:link {color:#bb233a;}
a:visited {color:#bb233a;}
a:hover {color:#bb233a;}
a:active {color:#bb233a;}
</style>
';
		
	$templateHeader = '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 10px 0 30px 0;">
<table style="background-color: #ffffff; width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr style="height: 52px;">
<td style="width: 467px; height: 52px;">
<table border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td bgcolor="#747474" width="20" height="50">&nbsp;</td>
<td bgcolor="#747474" width="600" height="50">
<img style="display: block;" src="{HOME_URL}content/images/sitograph/sitograph-logo-white-en.png" alt="Sitograph" width="265" height="80"/>
</td>
<td bgcolor="#747474" width="20" height="50">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 15px;">
<td style="width: 467px; height: 15px;">&nbsp;</td>
</tr>
<tr style="height: 400px;">
<td style="padding: 20px 20px 0px; color: #2c2c2c; font-size: 11pt; line-height: 140%; width: 467px; height: 400px;">
Dear {name}, 
<br /><br /> 
';
	$templateFooter = '
<br /><br /> 
Regards, <br /> 
Sitograph Team
</td>
</tr>
<tr style="height: 97px;">
<td style="padding: 0px 20px; color: #777777; background-color: #eeeeee; font-size: 9pt; line-height: 140%; width: 467px; height: 90px;">
<br /> 
<strong>Sitograph Content Management System.</strong>
Sitograph CMS is an online, open source website creation tool. 
Sitograph is a set of solutions for any online business.
It is simple and powerful content management system for website or online shop. 
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
';
    // update all Email Templates, adding Sitograph header and footer
    $resultQuery = API_getDBList(TABLE_MAIL_TEMPLATES);
    if ($resultQuery["ok"]) {
        foreach ($resultQuery["data"] as $template) {
            $templateBody = $templateHeader.$template["text"].$templateFooter;

            $result = API_updateDBItem(TABLE_MAIL_TEMPLATES, "header", "'".MSV_SQLEscape($header)."'", " `id` = '".$template["id"]."'");
            if (!$result["ok"]) {
                MSV_MessageError($result["msg"]);
            }

            $result = API_updateDBItem(TABLE_MAIL_TEMPLATES, "text", "'".MSV_SQLEscape($templateBody)."'", " `id` = '".$template["id"]."'");
            if (!$result["ok"]) {
                MSV_MessageError($result["msg"]);
            }
        }
    }
}