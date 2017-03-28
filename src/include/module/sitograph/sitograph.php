<?php
include(ABS_MODULE."/sitograph/config-menu.php");
MSV_assignData("admin_menu", $menu_ar);

MSV_IncludeJSFile("/content/js/sitograph.js");
MSV_IncludeCSSFile("/content/css/sitograph.css");

MSV_assignData("admin_title", $this->title." ".$this->version." <small>".$this->date."</small>");

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


$cms_icon = MSV_getConfig("admin_cms_icon");
if (empty($cms_icon)) {
	MSV_assignData("admin_cms_icon", "cms_favicon.gif");
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
	
	// trigger email sending on user registration
	MSV_setConfig("email_registration", 1, true, "*");
	
	// mailing options
	MSV_setConfig("email_from", "tech@sitograph.com", true, "*");
	MSV_setConfig("email_fromname", "Sitograph", true, "*");
	
	// add mail template
	$template = '
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
<td bgcolor="#3d3d3d" width="18" height="50">&nbsp;</td>
<td bgcolor="#3d3d3d" width="600" height="50"><img style="display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQkAAABQCAYAAAAKnoDvAAAAGXRFWHRTb2Z0d2Fy
ZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo3Qjg3QkM3RDA5QTAxMUU3ODkxNUMyNTVGRTkyRjAyRSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo3Qjg3QkM3RTA5QTAxMUU3ODkxNUMyNTVGRTkyRjAyRSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjdCODdCQzdCMDlBMDExRTc4OTE1QzI1NUZFOTJGMDJFIiBzdFJlZjpkb2N1
bWVudElEPSJ4bXAuZGlkOjdCODdCQzdDMDlBMDExRTc4OTE1QzI1NUZFOTJGMDJFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+4XCwkQAADn1JREFUeNrsnVtsHNUZgM+ZnZnd9WXttXMxJFB7nMROaC7gCEESGomaEioeWopdClKrCtVGlPahIDlCalWh0toitA8FgV1FJKkqWlz60AeEFPNQWhFasiWUJjEXX+MUCM7u2rvey9xOz+zMrMfD7Hqz3vWuvf+njDfencuZs3O++c9ljjEhBAEAAGSCgSwAAAAkAQAASAIAAJAEAAAgCQAAQBIAAIAk1hM/E5qlR7ZuEyEngEoFwziJzLy8d6d45DofWpAV9IvRMHpx5mMecgUASQC6IPZRQTQ1qQS53TSbECIR8fGLV9BL0x+6IXcAqG5UOMd3C/LdmxuoPTEVQlJ/YTbyv97ViHq3tELVAwBJVDIPtbbH99bxWvBAfxhRFpmjPxKIYD//8531GNooAJBEBfOHsVHv8UlFvRyLyDFFpoJQ9EWN0LpZCCVUFfk5qKIB0CZR8dy3YYv0xI4G1Fxdz3pcBAWTIrqSTMgnJq/iof9dZiGHAJBEBfFToVmalTjywqWPeLsoHhV8qIpl2StJRX790zn84mUQBFBZVPwFf6ytWd7vd6GPohK2f/aX2cvctzZulQ43EvUCrW2AIACIJCqM3+5slg80etG5cAI9/N8JEAAAOFCxDZfPtumCeGs2vkQQT2/bKj+ydTv0XgBAJUcSmiBub3Cjc3MyefTCGGe+/9aB3dJOn5dcTUr4+bEI+c00jLAEAKYiBdHoQYGwiKyC+M9XbhbbfT6VEI6rYhlUw8oYLg8AqLCGSzOCCIQS6EcXJ9PnHji0T2ypriYYqfzYQlT+
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" alt="Sitograph" width="200" /></td>
<td bgcolor="#3d3d3d" width="20" height="50">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 16px;">
<td style="width: 467px; height: 16px;">&nbsp;</td>
</tr>
<tr style="height: 382px;">
<td style="padding: 20px 20px 0px; color: #2c2c2c; font-family: Arial, sans-serif; font-size: 10.5pt; line-height: 140%; width: 467px; height: 382px;">
Здравствуйте, {name}, <br /><br />
Добро пожаловать в <strong>'.HOST.'</strong>. <br /> 
Для авторизации на сайте используйте следующие данные: <br />
<br /> 
Логин: <strong style="color: #333333;"> <a href="#">{email}</a></strong> 
<br /> Пароль: <strong style="color: #333333;">{password}</strong> <br /> 
Ссылка на вход в аккаунт: <a style="text-decoration:none; color:#bb233a; cursor: default;" href="'.HOME_URL.'login/">'.HOME_URL.'login/</a> 
<br /><br /> 
Для того чтобы начать, нажмите на ссылку: <br />
{verify_code} <br /> <br /> 
Для краткого руководства для начинающих, еженедельных тренировок и многого другого, посетите нашу
 <a style="text-decoration: none; color: #3092da;" href="#"><strong>группу в Facebook.</strong></a> <br /><br /> 
Спасибо, <br /> 
<a href="mailto:tech@sitograph.ru">Команда Sitograph</a>
<br /><br />
</td>
</tr>
<tr style="height: 97px;">
<td style="padding: 0px 20px; color: #777777; background-color: #eeeeee; font-family: Arial, sans-serif; font-size: 9pt; line-height: 140%; width: 467px; height: 97px;">
<br /> <strong>О Системе Управления Содержимым Сайтограф.</strong>
 Сайтограф CMS - это программа для создания и управления сайтом и его наполнением.
 Это набор критически важных решений для сайта любого размера, 
 что позволяет создавать онлайн решения для автоматизации различных бизнес процессов.
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';
	
	$header = '
<style type="text/css">
a {color:#bb233a;}
a:link { color:#bb233a;}
a:visited { color:#bb233a;}
a:hover { color:#bb233a;}
a:active { color:#bb233a;}
</style>
';
	
	MSV_MailTemplate_add("user_registration", "Welcome to ".HOST, $template, $header, "all");
}