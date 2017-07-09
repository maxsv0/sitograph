<?php

function ThemeDefaultInstall($module) {

    //
    // install function
    // run when module in installed

    $doc404Title = _t("structure.404");
    $doc404Text = "<h2>Page not found</h2>";
    $docExampleTitle = "h1. ". _t("structure.page1")." title";
    $docExampleText = file_get_contents($module->pathModule."install-example-page.html");

    $docHomepageText = '<div class="row">
<div class="col-sm-5 col-sm-offset-1">
<p>&nbsp;</p>
<p>&nbsp;</p>
<h1>Wellcome to Sitograph website creation tool.</h1>
<div class="lead">Simple and flexible Content Management System (CMS) for support and development of any Web Application.</div>
<p>&nbsp;</p>
<p class="lead"><a href="2" class="btn btn-primary btn-lg">Download Sitograph 1.0.beta</a>&nbsp;</p>
</div>
<div class="col-sm-6"><img src="/content/images/promo-top.png" class="img-responsive" /></div>
</div>';

    // create basic site structure
    MSV_Structure_add("all", "/", _t("structure.homepage"), "custom", "index.tpl", 1, "top", 1, "everyone", "", "", $docHomepageText);
    MSV_Structure_add("all", "/example-page/", _t("structure.page1"), "custom", "main.tpl", 1, "top", 2, "everyone", "", $docExampleTitle, $docExampleText);
    MSV_Structure_add("all", "/sitemap/", _t("structure.sitemap"), "custom", "sitemap.tpl", 0, "", 0, "everyone", "");
    MSV_Structure_add("all", "/404/", _t("structure.404"), "custom", "404.tpl", 0, "", 0, "everyone", "", $doc404Title, $doc404Text);

    // theme options
    MSV_setConfig("theme_active", "theme-default", true, "*");
    MSV_setConfig("theme_css_path", "/content/css/default.css", true, "*");
    MSV_setConfig("theme_js_path", "/content/js/default.js", true, "*");
    MSV_setConfig("theme_use_bootstrap", 1, true, "*");
    MSV_setConfig("theme_use_jquery", 1, true, "*");

    // theme options
    MSV_setConfig("theme_bg", "/content/images/bg_full.jpg", true, "*");
    MSV_setConfig("theme_cms_favicon", "/content/images/sitograph/cms_favicon.gif", true, "*");

    if (LANG === "ru" || LANG === "ua") {
        MSV_setConfig("theme_logo", "/content/images/sitograph/sitograph-logo-dark-ru.png", true, "*");
    } else {
        MSV_setConfig("theme_logo", "/content/images/sitograph/sitograph-logo-dark-en.png", true, "*");
    }

    MSV_setConfig("theme_copyright_text", "2016-2017 <a href='http://sitograph.com/' target='_blank'>Sitograph</a>", true, "*");
    MSV_setConfig("theme_header_contacts", "<a href='https://discord.gg/tPusyxP'>Join Discord channel</a><br>Skype: max.svistunov", true, "*");
}
