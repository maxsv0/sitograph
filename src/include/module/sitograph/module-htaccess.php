<?php
if (isset($_REQUEST["edit_mode"])) {
	MSV_MessageError("<b>WARNING!</b> PLEASE NOTE: After clicking the <b>Save</b> button changes will be made directly to the <b>.htaccess</b> file. <br><b>THIS CAN CAUSE WEBSITE STOP FUNCTIONING.</b>");
}

$htaccessUrl = ABS."/.htaccess";
if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	file_put_contents($htaccessUrl, $_POST["form_htaccess_content"]);
}
if (file_exists($htaccessUrl)) {
	$htaccessCont = file_get_contents($htaccessUrl);
	MSV_assignData("htaccess", $htaccessCont);
}
if (isset($_REQUEST["edit_mode"])) {
	MSV_assignData("htaccess_edit_mode", true);
}
if (!empty($_POST["save"])) {
	MSV_assignData("htaccess_edit_mode", true);
	// add message : ok saved??????
}
