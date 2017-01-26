<?php

$robotsUrl = ABS."/robots.txt";
if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	file_put_contents($robotsUrl, $_POST["form_robots_content"]);
}
if (file_exists($robotsUrl)) {
	$robotsCont = file_get_contents($robotsUrl);
	MSV_assignData("mcg_robots", $robotsCont);
}
if (isset($_REQUEST["edit_mode"])) {
	MSV_assignData("mcg_robots_edit_mode", true);
}
if (!empty($_POST["save"])) {
	MSV_assignData("mcg_robots_edit_mode", true);
	// add message : ok saved
}
