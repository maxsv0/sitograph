<?php


$designs = array();
foreach ($this->website->modules as $module) {
	if (strpos($module, "theme-") !== 0) continue;
	
	$moduleObj = msv_get("website.".$module);
	$designs[$module] = (array)$moduleObj;
}
msv_assign_data("admin_designs", $designs);

if (!empty($_GET["design_activate"])) {
	$themeName = $_GET["design_activate"];
	
	if (strpos($themeName, "theme-") === 0) {
		$themeID = substr($themeName, 6);
		$moduleObj = msv_get("website.".$themeName);

		if (!empty($moduleObj)) {

			$website = msv_get("website");
			foreach ($website->structure as $item) {
				
				if ($item["template"] !== $themeID) {
					$r = db_update(TABLE_STRUCTURE, "template", "'".db_escape($themeID)."'", " id = '".$item["id"]."'");
					
					if ($r["ok"]) {
                        msv_message_ok("Design $themeID set => ".$item["name"]." => OK");
					} else {
                        msv_message_error($r["msg"]);
					}
				} else {
                    msv_message_ok($item["name"]." already activated");
				}
			}

            msv_set_config("theme_active", $themeName, true, "*");
		} else {
            msv_message_error("Cant activate $themeName");
		}
	} else {
        msv_message_error("Unrecognized theme $themeName");
	}
}
