<?php
$configList = msv_get("website.configList");
if ($configList["theme_active"]["value"] !== "default") return;

$themeConfigList = array(
    "theme_logo" => "pic",
    "theme_css_path" => "str",
    "theme_js_path" => "str",
    "theme_copyright_text" => "str",
);

$themeConfig = array();

foreach ($themeConfigList as $configName => $configType) {
    $themeConfig[$configName] = array(
        "name" => _t("settings.".$configName),
        "type" => $configType,
        "value" => $configList[$configName]["value"],
        "id" => $configList[$configName]["id"],
    );
}

msv_set_config("theme_config", $themeConfig);
