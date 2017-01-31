<?php

$sitemapPath = ABS."/sitemap.xml";

if (isset($_REQUEST["generate"])) {
			
	API_SiteMapGenegate();
	MSV_MessageOK(_t("msg.sitemap_generated"));
}

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	file_put_contents($sitemapPath, $_POST["form_sitemap_content"]);
}



if (file_exists($sitemapPath)) {
	$sitemapCont = file_get_contents($sitemapPath);
	MSV_assignData("admin_sitemap", $sitemapCont);
}
if (isset($_REQUEST["edit_mode"])) {
	MSV_assignData("admin_sitemap_edit_mode", true);
}

if (!empty($_POST["save"])) {
	MSV_assignData("admin_robots_edit_mode", true);
	// add message : ok saved
}
