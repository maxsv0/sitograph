<?php

if (isset($_REQUEST["edit_mode"])) {
}
if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
}
if (!empty($_POST["save"])) {
	// add message : ok saved
}



$module_locales = array();
foreach ($this->website->modules as $module) {

	$moduleObj = MSV_get("website.".$module);
	$module_locales[$module] = $moduleObj->locales;
}
MSV_assignData("admin_module_locales", $module_locales);

MSV_assignData("admin_locales", $this->website->locales);
