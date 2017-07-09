<?php


$menu_ar = array();
$menu_index = array();
$menu_order = array();


$submenu = array();
$submenu["realtime"] = array(
	"name" => _t("admin.realtime"), 
	"access" => "admin",
	"url" => "/admin/?section=realtime",
	"file" => "index.tpl",
	"title" => _t("admin.realtime"), 
);
$submenu["analytics"] = array(
	"name" => _t("admin.analytics"), 
	"access" => "admin",
	"url" => "/admin/?section=analytics",
	"file" => "analytics.tpl",
	"title" => _t("admin.analytics")
);
$submenu["social"] = array(
	"name" => _t("admin.social"), 
	"access" => "admin",
	"url" => "/admin/?section=social",
	"file" => "social.tpl",
	"title" => _t("admin.social"),
);
$submenu["manual"] = array(
	"name" => _t("admin.manual"),
	"access" => "admin",
	"handler" => "module-manual.php",
	"url" => "/admin/?section=manual",
	"file" => "manual.tpl",
	"title" => _t("admin.manual")
);
$menu_index = array_merge($menu_index, array_keys($submenu));

$menu_ar["index"] = array(
	"name" => _t("admin.homepage"), 
	"access" => "admin",
	"file" => "index.tpl",
	"title" => _t("admin.homepage_title"),
	"submenu" => $submenu,
	"orderID" => 10,
);





$submenu = array();
$submenu["structure"] = array(
	"name" => _t("admin.structure_manage"), 
	"access" => "admin",
	"handler" => "module-structure.php",
	"table" => TABLE_STRUCTURE,
	"url" => "/admin/?section=structure",
	"file" => "structure.tpl",
	"title" => _t("admin.structure_title")
);
$submenu["menu"] = array(
	"name" => _t("admin.menu"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_MENU,
	"url" => "/admin/?section=menu",
	"file" => "menu.tpl",
	"title" => _t("admin.menu_title")
);
$submenu["documents"] = array(
	"name" => _t("admin.documents"), 
	"access" => "superadmin",
	"handler" => "module-table.php",
	"table" => TABLE_DOCUMENTS,
	"url" => "/admin/?section=documents",
	"file" => "documents.tpl",
	"title" => _t("admin.documents_title")
);
$submenu["seo"] = array(
	"name" => _t("admin.seo"), 
	"access" => "superadmin",
	"handler" => "module-table.php",
	"table" => TABLE_SEO,
	"url" => "/admin/?section=seo",
	"file" => "seo.tpl",
	"title" => _t("admin.seo_title")
);
$menu_index = array_merge($menu_index, array_keys($submenu));


$menu_ar["structure_docs"] = array(
	"name" => _t("admin.structure"), 
	"access" => "admin",
	"file" => "index.tpl",
	"title" => _t("admin.homepage_title"),
	"submenu" => $submenu,
	"orderID" => 20,
);
$menu_ar["users"] = array(
	"name" => _t("admin.users"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_USERS,
	"url" => "/admin/?section=users",
	"file" => "users.tpl",
	"title" => _t("admin.users_title"),
	"orderID" => 30,
);

$menu_ar["media_library"] = array(
	"name" =>  _t("admin.media_library"), 
	"access" => "admin",
	"handler" => "module-media.php",
	"url" => "/admin/?section=media_library",
	"file" => "media_library.tpl",
	"title" =>  _t("admin.media_library"),
	"orderID" => 40,
);


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
				"handler" => "module-table.php",
				"url" => "/admin/?section=".$module->name."&table=".$name,
				"file" => "custom.tpl",
				"title" => _t("table.".$name)." - ".$name
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
		
		$menu_index = array_merge($menu_index, array_keys($submenu));
	}
}




$menu_ar["mail_template"] = array(
	"name" => _t("admin.mail_template"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_MAIL_TEMPLATES,
	"url" => "/admin/?section=mail_template",
	"file" => "mail_template.tpl",
	"title" => _t("admin.mail_template_title"),
	"orderID" => 100,
);


$menu_ar["module_settings"] = array(
	"name" => _t("admin.module_settings"), 
	"access" => "superadmin",
	"url" => "/admin/?section=module_settings",
	"file" => "module_settings.tpl",
	"title" => _t("admin.module_settings_title"),
	"orderID" => 110,
);


$submenu = array();
$submenu["locales"] = array(
	"name" => _t("admin.locales"), 
	"access" => "superadmin",
	"handler" => "module-locales.php",
	"url" => "/admin/?section=locales",
	"file" => "locales.tpl",
	"title" => _t("admin.locales_title")
);
$submenu["robots"] = array(
	"name" => _t("admin.robots"), 
	"access" => "superadmin",
	"handler" => "module-robots.php",
	"url" => "/admin/?section=robots",
	"file" => "robots.tpl",
	"title" => _t("admin.robots_title")
);
$submenu["config"] = array(
	"name" => _t("admin.config"), 
	"access" => "superadmin",
	"handler" => "module-config.php",
	"url" => "/admin/?section=config",
	"file" => "config.tpl",
	"title" => _t("admin.config_title")
);
$submenu["editor"] = array(
    "name" => _t("admin.editor"),
    "access" => "superadmin",
    "handler" => "module-editor.php",
    "url" => "/admin/?section=editor",
    "file" => "editor.tpl",
    "title" => _t("admin.editor_title")
);
$menu_index = array_merge($menu_index, array_keys($submenu));

$menu_ar["dev_tools"] = array(
	"name" => _t("admin.dev_tools"), 
	"access" => "superadmin",
	"title" => _t("admin.dev_tools"),
	"submenu" => $submenu,
	"orderID" => 200,
);

$menu_ar["design"] = array(
	"name" => _t("admin.design"), 
	"access" => "admin",
	"handler" => "module-design.php",
	"url" => "/admin/?section=design",
	"file" => "design.tpl",
	"title" => _t("admin.design_title"),
	"orderID" => 100,
);

$menu_ar["site_settings"] = array(
	"name" => _t("admin.site_settings"), 
	"access" => "admin",
	"handler" => "module-table.php",
	"table" => TABLE_SETTINGS,
	"url" => "/admin/?section=site_settings",
	"file" => "site_settings.tpl",
	"title" => _t("admin.site_settings_title"),
	"orderID" => 105,
);

$menu_ar["history"] = array(
	"name" => _t("admin.history"), 
	"access" => "admin",
	"handler" => "module-history.php",
	"url" => "/admin/?section=history",
	"file" => "history.tpl",
	"title" => _t("admin.history_title"),
	"orderID" => 200,
);


$menu_index = array_merge($menu_index, array_keys($menu_ar));


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