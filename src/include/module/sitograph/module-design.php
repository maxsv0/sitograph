<?php


$designs = array();
foreach ($this->website->modules as $module) {
	if (strpos($module, "theme-") !== 0) continue;
	
	$moduleObj = MSV_get("website.".$module);
	$designs[$module] = (array)$moduleObj;
}
MSV_assignData("admin_designs", $designs);


if (!empty($_GET["design_activate"])) {
	$themeName = $_GET["design_activate"];
	
	if (strpos($themeName, "theme-") === 0) {
		$themeID = substr($themeName, 6);
		$moduleObj = MSV_get("website.".$themeName);

		if (!empty($moduleObj)) {

			$website = MSV_get("website");
			foreach ($website->structure as $item) {
				
				if ($item["template"] !== $themeID) {
					$r = API_updateDBItem(TABLE_STRUCTURE, "template", "'".MSV_SQLEscape($themeID)."'", " id = '".$item["id"]."'");
					
					if ($r["ok"]) {
						MSV_MessageOK("Design $themeID set => ".$item["name"]." => OK");
					} else {
						MSV_MessageError($r["msg"]);
					}
				} else {
					MSV_MessageOK($item["name"]." already activated");
				}
			}
			
			MSV_setConfig("theme_active", $themeName, true, "*");
		} else {
			MSV_MessageError("Cant activate $themeName");
		}
	} else {
		MSV_MessageError("Unrecognized theme $themeName");
	}
	
	
}
