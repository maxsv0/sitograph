<?php

function Install_ThemeSitograph($module) {

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
        "template" => "sitograph",
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
        "template" => "sitograph",
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
        "template" => "sitograph",
        "page_template" => "sitemap.tpl",
        "sitemap" => 1,
        "menu" => "bottom",
        "menu_order" => 5,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    $itemStructure = array(
        "url" => "/404/",
        "name" => _t("structure.404"),
        "template" => "sitograph",
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
        "template" => "sitograph",
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
		"template" => "sitograph",
		"page_template" => "main.tpl",
		"sitemap" => 1,
		"menu" => "bottom",
		"menu_order" => 2,
		"document_text" => $docTermsConditions,
	);
	msv_add_structure($itemStructure, array("lang" => "all"));

    Install_ThemeSitograph_Activate($module);
}

function Install_ThemeSitograph_Activate($module) {
    // general theme options
    msv_set_config("theme_active", "sitograph", true, "*", _t("settings.theme_active"), "theme");
    msv_set_config("theme_css_path", CONTENT_URL."/css/theme-sitograph.css", true, "*", _t("settings.theme_css_path"), "theme");
    msv_set_config("theme_js_path", CONTENT_URL."/js/theme-sitograph.js", true, "*", _t("settings.theme_js_path"), "theme");
    msv_set_config("theme_use_bootstrap", 1, true, "*", _t("settings.theme_use_bootstrap"), "theme");
    msv_set_config("theme_use_jquery", 1, true, "*", _t("settings.theme_use_jquery"), "theme");

    // custom theme options
    if (LANG === "ru" || LANG === "ua") {
        msv_set_config("theme_logo", CONTENT_URL."/images/sitograph/sitograph-logo-dark-ru.png", true, "*");
    } else {
        msv_set_config("theme_logo", CONTENT_URL."/images/sitograph/sitograph-logo-dark-en.png", true, "*");
    }
    msv_set_config("theme_bg", CONTENT_URL."/images/bg_full.jpg", true, "*");
    msv_set_config("theme_cms_favicon", CONTENT_URL."/images/sitograph/cms_favicon.gif", true, "*");

    msv_set_config("theme_copyright_text", "2016-".date("Y")." Sitograph CMS. <a href='https://www.sitograph.com/' target='_blank'>sitograph.com</a>", true, "*");
    msv_set_config("theme_header_contacts", "<a href='https://discord.gg/tPusyxP'>Join Discord channel</a><br>Skype: max.svistunov", true, "*");
}