<?php

$themeConfig = array(
        "theme_bg" => array(
                "name" => _t("theme.bg"),
                "type" => "pic",
                "value" => msv_get_config("theme_bg"),
        ),
        "theme_logo" => array(
                "name" => _t("theme.logo"),
                "type" => "pic",
                "value" => msv_get_config("theme_logo"),
        ),
        "theme_css_path" => array(
                "name" => _t("theme.css_path"),
                "type" => "str",
                "value" => msv_get_config("theme_css_path"),
        ),
        "theme_js_path" => array(
                "name" => _t("theme.js_path"),
                "type" => "str",
                "value" => msv_get_config("theme_js_path"),
        ),
        "theme_copyright_text" => array(
                "name" => _t("theme.copyright_text"),
                "type" => "str",
                "value" => msv_get_config("theme_copyright_text"),
        ),
);

msv_set_config("theme_config", $themeConfig);

if (isset($_GET["config"])) {
    msv_set_config("theme_config_show", 1);
}