<?php

function Install_ThemeDefault($module) {

    //
    // install function
    // run when module in installed

    $doc404Title = _t("structure.404");
    $doc404Text =  "<h2>"._t("structure.404_doc")."<h2>";
    $docExampleTitle = "h1. ". _t("structure.page1")." title";
    $docExampleText = msv_load_module_doc($module->pathModule, "example-page");

    $docHomepageText = 'Homepage';

    // create basic site structure
    $itemStructure = array(
        "url" => "/",
        "name" => _t("structure.homepage"),
        "template" => "custom",
        "page_template" => "index.tpl",
        "sitemap" => 1,
        "menu" => "top",
        "menu_order" => 1,
        "document_text" => $docHomepageText,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/example-page/",
        "name" => _t("structure.page1"),
        "template" => "custom",
        "page_template" => "main.tpl",
        "sitemap" => 1,
        "menu" => "top",
        "menu_order" => 2,
        "document_title" => $docExampleTitle,
        "document_text" => $docExampleText,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/sitemap/",
        "name" => _t("structure.sitemap"),
        "template" => "custom",
        "page_template" => "sitemap.tpl",
        "sitemap" => 1,
        "menu" => "bottom",
        "menu_order" => 5,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/404/",
        "name" => _t("structure.404"),
        "template" => "custom",
        "page_template" => "404.tpl",
        "sitemap" => 0,
        "document_title" => $doc404Title,
        "document_text" => $doc404Text,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    $docPrivacyPolicy = msv_load_module_doc($module->pathModule, "privacy-policy");
    $itemStructure = array(
        "url" => "/privacy-policy/",
        "name" => _t("structure.privacy_policy"),
        "template" => "custom",
        "page_template" => "main.tpl",
        "sitemap" => 1,
        "menu" => "bottom",
        "menu_order" => 1,
        "document_text" => $docPrivacyPolicy,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

	$docTermsConditions = msv_load_module_doc($module->pathModule, "terms-conditions");
	$itemStructure = array(
		"url" => "/terms-and-conditions/",
		"name" => _t("structure.terms_conditions"),
		"template" => "custom",
		"page_template" => "main.tpl",
		"sitemap" => 1,
		"menu" => "bottom",
		"menu_order" => 2,
		"document_text" => $docTermsConditions,
	);
	msv_add_structure($itemStructure, array("lang" => "all"));

    // general theme options
    msv_set_config("theme_active", "theme-default", true, "*");
    msv_set_config("theme_css_path", "/content/css/default.css", true, "*");
    msv_set_config("theme_js_path", "/content/js/default.js", true, "*");
    msv_set_config("theme_use_bootstrap", 1, true, "*");
    msv_set_config("theme_use_jquery", 1, true, "*");

    // custom theme options
    msv_set_config("theme_bg", "", true, "*", _t("settings.theme_bg"), "theme");
    msv_set_config("theme_cms_favicon", "", true, "*", _t("settings.theme_cms_favicon"), "theme");
    msv_set_config("theme_logo", "", true, "*", _t("settings.theme_logo"), "theme");
    msv_set_config("theme_copyright_text", "2016-".date("Y")." MSV Framework", true, "*", _t("settings.theme_copyright_text"), "theme");
    msv_set_config("theme_header_contacts", "", true, "*", _t("settings.theme_header_contacts"), "theme");
}
