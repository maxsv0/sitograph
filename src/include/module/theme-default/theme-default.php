<?php


function ThemeDefaultInstall($module) {
	
	// 
	// install function
	// run when module in installed

	$doc404Title = _t("structure.404");
	$doc404Text = "<h2>Page not found</h2>";
	$docExampleTitle = "h1. ". _t("structure.page1");
	$docExampleText = '<h2>h2. Website heading <small>With secondary text</small></h2>
<h3>h3. Website heading</h3>
<h4>h4. Website heading</h4>
<h5>h5. Website heading</h5>
<h6>h6. Website heading</h6>
<hr />
<h2>Buttons</h2>
<h3>Options</h3>
<p><button type="button" class="btn btn-default">Default</button> <button type="button" class="btn btn-primary">Primary</button> <button type="button" class="btn btn-success">Success</button> <button type="button" class="btn btn-info">Info</button> <button type="button" class="btn btn-warning">Warning</button> <button type="button" class="btn btn-danger">Danger</button> <button type="button" class="btn btn-link">Link</button></p>
<h3>Sizes</h3>
<p><button type="button" class="btn btn-primary btn-lg">Large button</button> <button type="button" class="btn btn-default btn-lg">Large button</button></p>
<p><button type="button" class="btn btn-primary">Default button</button> <button type="button" class="btn btn-default">Default button</button></p>
<p><button type="button" class="btn btn-primary btn-sm">Small button</button> <button type="button" class="btn btn-default btn-sm">Small button</button></p>
<p><button type="button" class="btn btn-primary btn-xs">Extra small button</button> <button type="button" class="btn btn-default btn-xs">Extra small button</button></p>
<hr />
<h2>Grid system</h2>
<div class="row show-grid">
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
<div class="col-md-1">.col-md-1</div><div class="col-md-1">.col-md-1</div>
</div>
<div class="row show-grid">
<div class="col-md-8">.col-md-8</div><div class="col-md-4">.col-md-4</div>
</div>
<div class="row show-grid">
<div class="col-md-4">.col-md-4</div><div class="col-md-4">.col-md-4</div><div class="col-md-4">.col-md-4</div>
</div>
<div class="row show-grid">
<div class="col-md-6">.col-md-6</div><div class="col-md-6">.col-md-6</div>
</div>
<hr />
<p>&nbsp;</p>
<p class="lead">More info can be found at <a href="https://getbootstrap.com/css/">Bootrap Docs</a></p>
<p>&nbsp;</p>';
	
	// create basic site structure
	MSV_Structure_add("all", "/", _t("structure.homepage"), "default", "index.tpl", 1, "top", 1, "everyone", "");
	MSV_Structure_add("all", "/example-page/", _t("structure.page1"), "default", "main.tpl", 1, "top", 2, "everyone", "", $docExampleTitle, $docExampleText);
	MSV_Structure_add("all", "/sitemap/", _t("structure.sitemap"), "default", "sitemap.tpl", 0, "", 0, "everyone", "");
	MSV_Structure_add("all", "/404/", _t("structure.404"), "default", "404.tpl", 0, "", 0, "everyone", "", $doc404Title, $doc404Text);
	
	// theme options
	MSV_setConfig("theme_active", "theme-default", true, "*");
	MSV_setConfig("theme_css_path", "/content/css/default.css", true, "*");
	MSV_setConfig("theme_js_path", "/content/js/default.js", true, "*");
	MSV_setConfig("theme_include_font", "<link href='https://fonts.googleapis.com/css?family=Roboto:300,500&subset=latin,cyrillic' rel='stylesheet' type='text/css'>", true, "*");
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
        "theme_css_path" => array(
                "name" => _t("theme.css_path"),
                "type" => "str",
                "value" => MSV_getConfig("theme_css_path"),
        ),
        "theme_js_path" => array(
                "name" => _t("theme.js_path"),
                "type" => "str",
                "value" => MSV_getConfig("theme_js_path"),
        ),
        "theme_include_font" => array(
                "name" => _t("theme.include_font"),
                "type" => "str",
                "value" => MSV_getConfig("theme_include_font"),
        ),
        "theme_copyright_text" => array(
                "name" => _t("theme.copyright_text"),
                "type" => "str",
                "value" => MSV_getConfig("theme_copyright_text"),
        ),
);

MSV_setConfig("theme_config", $themeConfig);

if (isset($_GET["config"])) {
	MSV_setConfig("theme_config_show", 1);
}