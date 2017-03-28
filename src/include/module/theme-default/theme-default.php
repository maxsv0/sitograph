<?php


function ThemeDefaultInstall($module) {
	
	// 
	// install function
	// run when module in installed

	
	// create basic site structure
	MSV_Structure_add("all", "/", _t("structure.homepage"), "default", "index.tpl", 1, "top", 1, "everyone");
	MSV_Structure_add("all", "/example-page/", _t("structure.page1"), "default", "main.tpl", 1, "top", 2, "everyone");
	MSV_Structure_add("all", "/sitemap/", _t("structure.sitemap"), "default", "sitemap.tpl", 0, "", 0, "everyone");
	MSV_Structure_add("all", "/404/", _t("structure.404"), "default", "404.tpl", 0, "", 0, "everyone");
	
	// theme options
	MSV_setConfig("theme_active", "theme-default", true, "*");
	MSV_setConfig("theme_css_path", "/content/css/default.css", true, "*");
	MSV_setConfig("theme_js_path", "/content/js/default.js", true, "*");
	MSV_setConfig("theme_include_font", "<link href='https://fonts.googleapis.com/css?family=Roboto:300,500&subset=latin,cyrillic' rel='stylesheet' type='text/css'>", true, "*");
	MSV_setConfig("theme_use_bootstrap", 1, true, "*");
	MSV_setConfig("theme_use_jquery", 1, true, "*");
	
	// theme options
	MSV_setConfig("theme_bg", "/content/images/bg_full.gif", true, "*");
	MSV_setConfig("theme_logo", "/content/images/sitograph_logo.png", true, "*");
}


$themeConfig = array(
	"theme_bg" => array(
		"name" => _t("theme.bg"),
		"type" => "pic",
		"value" => MSV_getConfig("theme_bg"),
	),
	"theme_logo" => array(
		"name" => _t("theme.logo"),
		"type" => "pic",
		"value" => MSV_getConfig("theme_logo"),
	),
);

MSV_setConfig("theme_config", $themeConfig);

if (isset($_GET["config"])) {
	MSV_setConfig("theme_config_show", 1);
}