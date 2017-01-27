<?php


$menu_ar = array();

$menu_ar["index"] = array(
	"name" => _t("admin.homepage"), 
	"access" => "admin",
	"handler" => "module-robots.php",
	"url" => "/admin/",
	"file" => "index.tpl",
	"title" => _t("admin.homepage_title"),
	"orderID" => 10,
);
$menu_ar["users"] = array(
	"name" => _t("admin.users"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_USERS,
	"url" => "/admin/?section=users",
	"file" => "users.tpl",
	"title" => _t("admin.users_title"),
	"orderID" => 11,
);
$menu_ar["structure"] = array(
	"name" => _t("admin.structure"), 
	"access" => "admin",
	"handler" => "module-structure.php",
	"table" => TABLE_STRUCTURE,
	"url" => "/admin/?section=structure",
	"file" => "structure.tpl",
	"title" => _t("admin.structure_title"),
	"orderID" => 12,
);
$menu_ar["menu"] = array(
	"name" => _t("admin.menu"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_MENU,
	"url" => "/admin/?section=menu",
	"file" => "menu.tpl",
	"title" => _t("admin.menu_title"),
	"orderID" => 13,
);
$menu_ar["documents"] = array(
	"name" => _t("admin.documents"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_DOCUMENTS,
	"url" => "/admin/?section=documents",
	"file" => "documents.tpl",
	"title" => _t("admin.documents_title"),
	"orderID" => 14,
);
$menu_ar["files_and_doc"] = array(
	"name" =>  _t("admin.files_and_doc"), 
	"access" => "superadmin",
	"handler" => "module-docs.php",
	"url" => "/admin/?section=files_and_doc",
	"file" => "files_and_doc.tpl",
	"title" => _t("admin.files_and_doc_title"),
	"orderID" => 15,
);
$menu_ar["site_settings"] = array(
	"name" => _t("admin.site_settings"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_SETTINGS,
	"url" => "/admin/?section=site_settings",
	"file" => "site_settings.tpl",
	"title" => _t("admin.site_settings_title"),
	"orderID" => 16,
);
$menu_ar["locales"] = array(
	"name" => _t("admin.locales"), 
	"access" => "superadmin",
	"handler" => "module-locales.php",
	"url" => "/admin/?section=locales",
	"file" => "locales.tpl",
	"title" => _t("admin.locales_title"),
	"orderID" => 17,
);
$menu_ar["mail_template"] = array(
	"name" => _t("admin.mail_template"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_MAIL_TEMPLATES,
	"url" => "/admin/?section=mail_template",
	"file" => "mail_template.tpl",
	"title" => _t("admin.mail_template_title"),
	"orderID" => 18,
);
$menu_ar["stat"] = array(
	"name" => _t("admin.stat"), 
	"access" => "admin",
	"url" => "/admin/?section=stat",
	"file" => "stat.tpl",
	"title" => _t("admin.stat_title"),
	"orderID" => 19,
);
$menu_ar["seo"] = array(
	"name" => _t("admin.seo"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_SEO,
	"url" => "/admin/?section=seo",
	"file" => "seo.tpl",
	"title" => _t("admin.seo_title"),
	"orderID" => 20,
);
$menu_ar["robots"] = array(
	"name" => _t("admin.robots"), 
	"access" => "superadmin",
	"handler" => "module-robots.php",
	"url" => "/admin/?section=robots",
	"file" => "robots.tpl",
	"title" => _t("admin.robots_title"),
	"orderID" => 21,
);
$menu_ar["sitemap"] = array(
	"name" => _t("admin.sitemap"), 
	"access" => "superadmin",
	"handler" => "module-sitemap.php",
	"url" => "/admin/?section=sitemap",
	"file" => "sitemap.tpl",
	"title" => _t("admin.sitemap_title"),
	"orderID" => 22,
);
$menu_ar["manual"] = array(
	"name" => _t("admin.manual"), 
	"access" => "admin",
	"handler" => "module-manual.php",
	"url" => "",
	"file" => "manual.tpl",
	"title" => _t("admin.manual_title"),
	"orderID" => 23,
);
$menu_ar["module_settings"] = array(
	"name" => _t("admin.module_settings"), 
	"access" => "superadmin",
	"url" => "/admin/?section=module_settings",
	"file" => "module_settings.tpl",
	"title" => _t("admin.module_settings_title"),
	"orderID" => 24,
);

$menu_ar["module_catalog"] = array(
	"name" => _t("admin.module_catalog"), 
	"access" => "admin",
    "handler" => "module-catalog.php",
	"url" => "/admin/?section=module_catalog",
	"file" => "module_catalog.tpl",
	"title" => _t("admin.module_catalog_title"),
	"orderID" => 25,
);

$menu_ar["module_comments"] = array(
	"name" => _t("admin.module_comments"), 
	"access" => "admin",
    "table" => TABLE_COMMENTS,
    "handler" => "module-comments.php",
	"url" => "/admin/?section=module_comments",
	"file" => "module_comments.tpl",
	"title" => _t("admin.module_comments_title"),
	"orderID" => 26,
);

$menu_ar["module_search"] = array(
	"name" => _t("admin.module_search"), 
	"access" => "admin",
    "handler" => "module-search.php",
	"url" => "/admin/?section=module_search",
	"file" => "search.tpl",
	"title" => _t("admin.module_search_title"),
	"orderID" => 27,
);

//$menu_ar["design"] = array(
//	"name" => _t("admin.design"), 
//	"access" => "superadmin",
//	"url" => "/admin/?section=design",
//	"file" => "design.tpl",
//	"title" => _t("admin.design_title")
//);
//$menu_ar["history"] = array(
//	"name" => _t("admin.history"), 
//	"access" => "superadmin",
//	"url" => "/admin/?section=history",
//	"file" => "history.tpl",
//	"title" => _t("admin.history_title")
//);

foreach ($this->website->modules as $module) {
	$module = MSV_get("website.".$module);
	if (!empty($module->adminMenu) && $module->adminMenu) {
		
		$submenu = array();
		
		foreach ($module->tables as $tableInfo) {
			$name = $tableInfo["name"];
			
			$submenu[$name] = array(
				"name" => _t("table.".$name), 
				"table" => $name, 
				"access" => "admin",
				"url" => "/admin/?section=".$module->name."&table=".$name,
				"file" => "custom.tpl",
				"title" =>  _t("table.".$name)." - ".$module->description
			);
		}
		$menu_ar[$module->name] = array(
			"name" => _t("module.".$module->name), 
			"access" => "admin",
			"handler" => "module-table.php",
			"url" => "/admin/?section=".$module->name,
			"file" => "custom.tpl",
			"title" => $module->description,
			"submenu" => $submenu,
			"orderID" => $module->adminMenuOrder
		);
	}
}



/// reorder menu accrding to adminMenuOrder
$menu_order_index = array();
foreach ($menu_ar as $menuID => $menuItem) {
	$num = 50;
	if (!empty($menuItem["orderID"])) {
		$num = $menuItem["orderID"];
	}
	$menu_order_index[$menuID] = $num;
}

asort($menu_order_index);

// build new menu
$menu_ar2 = array();
foreach ($menu_order_index as $menuID => $num) {
	$menu_ar2[$menuID] = $menu_ar[$menuID];
}

$menu_ar = $menu_ar2;