<?php

$sitemapPath = ABS."/sitemap.xml";

if (isset($_REQUEST["generate"])) {
			
	$sitemapXML = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
';
	$website = MSV_get("website");

	foreach ($website->languages as $langID) {
		$query = API_getDBList(TABLE_SEO, "`sitemap` > 0", "`url` desc", 10000, 0,  $langID);
		if ($query["ok"] && $query["data"]) {
			foreach ($query["data"] as $item) {
				$sitemapXML .= "
<url>
<loc>".HOME_LINK.$item["url"]."</loc>
<priority>1</priority>
<lastmod>".date("Y-m-d", strtotime($item["updated"]))."</lastmod>
</url>\n";
			}
		}
	}
	
	$sitemapXML .= "</urlset>";
	file_put_contents($sitemapPath, $sitemapXML);

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
