<?php

$menu_ar = array();
$menu_index = array();
$menu_order = array();

$submenu = array();
$submenu["index"] = array(
    "name" => _t("admin.homepage"),
    "access" => "admin",
    "url" => ADMIN_URL."",
    "file" => "index.tpl",
    "title" => _t("admin.homepage_title"),
    "orderID" => 1,
);
$submenu["realtime"] = array(
    "name" => _t("admin.realtime"),
    "access" => "admin",
    "url" => ADMIN_URL."?section=realtime",
    "file" => "realtime.tpl",
    "title" => _t("admin.realtime"),
);
$submenu["leads"] = array(
    "name" => _t("admin.leads"),
    "access" => "admin",
    "url" => ADMIN_URL."?section=leads",
    "file" => "leads.tpl",
    "title" => _t("admin.leads_title"),
);
$submenu["analytics"] = array(
    "name" => _t("admin.analytics"),
    "access" => "admin",
    "url" => ADMIN_URL."?section=analytics",
    "file" => "analytics.tpl",
    "title" => _t("admin.analytics")
);
//$submenu["social"] = array(
//    "name" => _t("admin.social"),
//    "access" => "admin",
//    "url" => ADMIN_URL."?section=social",
//    "file" => "social.tpl",
//    "title" => _t("admin.social"),
//);
$submenu["manual"] = array(
    "name" => _t("admin.manual"),
    "access" => "admin",
    "handler" => "module-manual.php",
    "url" => ADMIN_URL."?section=manual",
    "file" => "manual.tpl",
    "title" => _t("admin.manual_title")
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
    "url" => ADMIN_URL."?section=structure",
    "file" => "structure.tpl",
    "title" => _t("admin.structure_title")
);
$submenu["menu"] = array(
    "name" => _t("admin.menu"),
    "access" => "admin",
    "handler" => "module-table.php",
    "table" => TABLE_MENU,
    "url" => ADMIN_URL."?section=menu",
    "file" => "menu.tpl",
    "title" => _t("admin.menu_title")
);
$submenu["documents"] = array(
    "name" => _t("admin.documents"),
    "access" => "admin",
    "handler" => "module-table.php",
    "table" => TABLE_DOCUMENTS,
    "url" => ADMIN_URL."?section=documents",
    "file" => "documents.tpl",
    "title" => _t("admin.documents_title")
);
$submenu["seo"] = array(
    "name" => _t("admin.seo"),
    "access" => "admin",
    "handler" => "module-table.php",
    "table" => TABLE_SEO,
    "url" => ADMIN_URL."?section=seo",
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
    "handler" => "module-users.php",
    "table" => TABLE_USERS,
    "url" => ADMIN_URL."?section=users",
    "file" => "users.tpl",
    "title" => _t("admin.users_title"),
    "orderID" => 30,
);

$menu_ar["media_library"] = array(
    "name" =>  _t("admin.media_library"),
    "access" => "admin",
    "handler" => "module-media.php",
    "url" => ADMIN_URL."?section=media_library",
    "file" => "media_library.tpl",
    "title" =>  _t("admin.media_library"),
    "orderID" => 40,
);


foreach ($this->website->modules as $module) {
    $module = msv_get("website.".$module);
    if (!empty($module->adminMenu) && $module->adminMenu) {

        $submenu = array();

        foreach ($module->tables as $tableInfo) {
            $name = $tableInfo["name"];

            $submenu[$name] = array(
                "name" => _t("table.".$name),
                "module" => $module->name,
                "table" => $name,
                "access" => "admin",
                "handler" => "module-table.php",
                "url" => ADMIN_URL."?section=".$module->name."&table=".$name,
                "file" => "custom.tpl",
                "title" => _t("module.".$module->name)." - "._t("table.".$name)
            );

            $handlerCustom = "module-".$module->name.".php";
            if (file_exists(ABS_MODULE."/sitograph/".$handlerCustom)) {
                $submenu[$name]["handler"] = $handlerCustom;
            }
        }
        $menu_ar[$module->name] = array(
            "name" => _t("module.".$module->name),
            "access" => "admin",
            "handler" => "module-table.php",
            "url" => ADMIN_URL."?section=".$module->name,
            "file" => "custom.tpl",
            "title" => $module->description,
            "submenu" => $submenu,
            "orderID" => $module->adminMenuOrder
        );

        $menu_index = array_merge($menu_index, array_keys($submenu));
    }
}





$menu_ar["module_settings"] = array(
    "name" => _t("admin.module_settings"),
    "access" => "dev",
    "url" => ADMIN_URL."?section=module_settings",
    "file" => "module_settings.tpl",
    "title" => _t("admin.module_settings_title"),
    "orderID" => 150,
);

// Submenu for 'emails'
$submenu = array();
$submenu["send_email"] = array(
    "name" => _t("admin.send_email"),
    "access" => "admin",
    "handler" => "module-email.php",
    "url" => ADMIN_URL."?section=send_email",
    "file" => "send_email.tpl",
    "title" => _t("admin.send_email_title"),
    "orderID" => 10,
);
$submenu["maillog"] = array(
    "name" => _t("admin.maillog"),
    "access" => "admin",
    "handler" => "module-table.php",
    "table" => TABLE_MAIL_LOG,
    "url" => ADMIN_URL."?section=maillog",
    "file" => "custom.tpl",
    "title" => _t("admin.maillog_title"),
    "orderID" => 50,
);
$submenu["mail_template"] = array(
    "name" => _t("admin.mail_template"),
    "access" => "admin",
    "handler" => "module-table.php",
    "table" => TABLE_MAIL_TEMPLATES,
    "url" => ADMIN_URL."?section=mail_template",
    "file" => "mail_template.tpl",
    "title" => _t("admin.mail_template_title"),
    "orderID" => 100,
);

// attach 'emails' to menu
$menu_ar["emails"] = array(
    "name" => _t("admin.emails"),
    "access" => "admin",
    "title" => _t("admin.emails"),
    "submenu" => $submenu,
    "orderID" => 110,
);
$menu_index = array_merge($menu_index, array_keys($submenu));
// attached

$submenu = array();
/*
TODO: rework locales
		not working now, cause config.xml was split
*/
$submenu["locales"] = array(
        "name" => _t("admin.locales"),
        "access" => "dev",
        "handler" => "module-locales.php",
        "url" => ADMIN_URL."?section=locales",
        "file" => "locales.tpl",
        "title" => _t("admin.locales_title")
);
$submenu["cronjobs"] = array(
    "name" => _t("admin.cronjobs"),
    "access" => "dev",
    "handler" => "module-table.php",
    "table" => TABLE_CRONJOBS,
    "url" => ADMIN_URL."?section=cronjobs",
    "file" => "cronjobs.tpl",
    "title" => _t("admin.cronjobs_title"),
    "orderID" => 101,
);
$submenu["cronjobslog"] = array(
    "name" => _t("admin.cronjobslog"),
    "access" => "dev",
    "handler" => "module-table.php",
    "table" => TABLE_CRONJOBS_LOGS,
    "url" => ADMIN_URL."?section=cronjobslog",
    "file" => "custom.tpl",
    "title" => _t("admin.cronjobslog_title"),
    "orderID" => 102,
);
$submenu["robots"] = array(
    "name" => _t("admin.robots"),
    "access" => "dev",
    "handler" => "module-robots.php",
    "url" => ADMIN_URL."?section=robots",
    "file" => "robots.tpl",
    "title" => _t("admin.robots_title")
);
$submenu["sitemap"] = array(
    "name" => _t("admin.sitemap"),
    "access" => "dev",
    "handler" => "module-sitemap.php",
    "url" => ADMIN_URL."?section=sitemap",
    "file" => "sitemap.tpl",
    "title" => _t("admin.sitemap_title")
);
$submenu["config"] = array(
    "name" => _t("admin.config"),
    "access" => "dev",
    "handler" => "module-config.php",
    "url" => ADMIN_URL."?section=config",
    "file" => "config.tpl",
    "title" => _t("admin.config_title")
);
$submenu["editor"] = array(
    "name" => _t("admin.editor"),
    "access" => "dev",
    "handler" => "module-editor.php",
    "url" => ADMIN_URL."?section=editor",
    "file" => "editor.tpl",
    "title" => _t("admin.editor_title")
);
$menu_index = array_merge($menu_index, array_keys($submenu));

$menu_ar["dev_tools"] = array(
    "name" => _t("admin.dev_tools"),
    "access" => "dev",
    "title" => _t("admin.dev_tools"),
    "submenu" => $submenu,
    "orderID" => 200,
);

$menu_ar["design"] = array(
    "name" => _t("admin.design"),
    "access" => "admin",
    "handler" => "module-design.php",
    "url" => ADMIN_URL."?section=design",
    "file" => "design.tpl",
    "title" => _t("admin.design_title"),
    "orderID" => 100,
);

$menu_ar["site_settings"] = array(
    "name" => _t("admin.site_settings"),
    "access" => "admin",
    "handler" => "module-settings.php",
    "table" => TABLE_SETTINGS,
    "url" => ADMIN_URL."?section=site_settings",
    "file" => "site_settings.tpl",
    "title" => _t("admin.site_settings_title"),
    "orderID" => 105,
);

$menu_ar["history"] = array(
    "name" => _t("admin.history"),
    "access" => "dev",
    "handler" => "module-history.php",
    "url" => ADMIN_URL."?section=history",
    "file" => "history.tpl",
    "title" => _t("admin.history_title"),
    "orderID" => 200,
);


$menu_index = array_merge($menu_index, array_keys($menu_ar));


/// reorder menu according to adminMenuOrder
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
