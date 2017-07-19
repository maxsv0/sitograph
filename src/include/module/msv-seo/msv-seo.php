<?php

function setPageSEO($seo) {
	$result = db_get(TABLE_SEO, " `url` = '".$seo->website->requestUrlRaw."' ");
	if (!$result["ok"]) {
	    msv_message_error($result["msg"]);
	}
	$row = $result["data"];
	if (empty($row)) return false;

	return SEO_set($row["title"], $row["keywords"], $row["description"]);
}


function SEO_set($title = "", $description = "", $keywords = "") {
    msv_log("Module:SEO -> Set: $title");
	
	$website = msv_get("website");
	
	$website->page["title"] = $title;
	$website->page["keywords"] = $description;
	$website->page["description"] = $keywords;
	
	return true;
}


		
		
		