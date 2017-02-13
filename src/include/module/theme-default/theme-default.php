<?php


function ThemeDefaultInstall($module) {
	
	// 
	// install function
	// run when module in installed

	
	// create basic site structure
	MSV_Structure_add("all", "/", _t("structure.homepage"), "default", "index.tpl", 1, "top", 1, "everyone");
	MSV_Structure_add("all", "/the-first-page/", _t("structure.first_page"), "default", "main.tpl", 1, "top", 2, "everyone");
	MSV_Structure_add("all", "/404/", _t("structure.404"), "default", "404.tpl", 0, "", 0, "everyone");
	MSV_Structure_add("*", "/admin/", _t("structure.admin_homepage"), "default", "admin.tpl", 0, "", 0, "admin");
	MSV_Structure_add("*", "/admin/login/", _t("structure.admin_login"), "default", "admin-login.tpl", 0, "", 0, "everyone");
	
	// theme options
	MSV_setConfig("theme_active", "theme-default", true, "*");
	MSV_setConfig("theme_css_path", "/content/default/css/default.css", true, "*");
	MSV_setConfig("theme_js_path", "/content/default/js/default.js", true, "*");
//	MSV_setConfig("theme_include_font", "<link href='https://fonts.googleapis.com/css?family=Roboto:300,500&subset=latin,cyrillic' rel='stylesheet' type='text/css'>", true, "*");
	MSV_setConfig("theme_use_bootstrap", 1, true, "*");
	MSV_setConfig("theme_use_jquery", 1, true, "*");
}