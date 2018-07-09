<?php


$designs = array();
foreach ($this->website->modules as $module) {
	if (strpos($module, "theme-") !== 0) continue;
    $themeID = substr($module, 6);

	$moduleObj = msv_get("website.".$module);
	$designs[$themeID] = (array)$moduleObj->config;
}
msv_assign_data("admin_designs", $designs);

if (!empty($_GET["design_activate"])) {
    $themeName = $_GET["design_activate"];
    $moduleObj = msv_get("website.theme-".$themeName);

	if (!empty($moduleObj)) {
        $website = msv_get("website");
        foreach ($website->structure as $item) {

            if ($item["template"] !== $themeName) {
                $r = db_update(TABLE_STRUCTURE, "template", "'".db_escape($themeName)."'", " id = '".$item["id"]."'");

                if ($r["ok"]) {
                    msv_message_ok("Design $themeName set => ".$item["name"]." => OK");
                } else {
                    msv_message_error($r["msg"]);
                }
            } else {
                msv_message_ok($item["name"]." already activated");
            }
        }

        msv_set_config("theme_active", $themeName, true, "*");

        $themeHook = $moduleObj->config["enableHook"];
        if (!empty($themeHook) && function_exists($themeHook)) {
            $evalCode = $themeHook."(\$moduleObj);";
            eval($evalCode);
        }
	} else {
        msv_message_error("Unrecognized theme $themeName");
	}
}
