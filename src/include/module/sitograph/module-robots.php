<?php

$robotsUrl = ABS."/robots.txt";
if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	file_put_contents($robotsUrl, $_POST["form_robots_content"]);
}
if (file_exists($robotsUrl)) {
	$robotsCont = file_get_contents($robotsUrl);
    msv_assign_data("robots", $robotsCont);
} else {
    msv_message_error("Robots.txt ."._t("not_found"));
}

if (isset($_REQUEST["edit_mode"])) {
    msv_assign_data("robots_edit_mode", true);
}
if (!empty($_POST["save"])) {
    msv_assign_data("robots_edit_mode", true);
	// add message : ok saved
}
