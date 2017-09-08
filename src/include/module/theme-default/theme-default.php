<?php

$themeConfig = array(
    "theme_bg" => array(
        "name" => _t("settings.theme_bg"),
        "type" => "pic",
        "value" => msv_get_config("theme_bg"),
    ),
    "theme_logo" => array(
        "name" => _t("settings.theme_logo"),
        "type" => "pic",
        "value" => msv_get_config("theme_logo"),
    ),
    "theme_css_path" => array(
        "name" => _t("settings.theme_css_path"),
        "type" => "str",
        "value" => msv_get_config("theme_css_path"),
    ),
    "theme_js_path" => array(
        "name" => _t("settings.theme_js_path"),
        "type" => "str",
        "value" => msv_get_config("theme_js_path"),
    ),
    "theme_copyright_text" => array(
        "name" => _t("settings.theme_copyright_text"),
        "type" => "str",
        "value" => msv_get_config("theme_copyright_text"),
    ),
);

msv_set_config("theme_config", $themeConfig);
