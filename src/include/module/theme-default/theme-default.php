<?php

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