<?php

function setPageSEO($seo) {
	$result = API_getDBItem(TABLE_SEO, " `url` = '".$seo->website->requestUrlRaw."' ");
	if (!$result["ok"]) {
		API_callError($result["msg"]);
	} 
	$row = $result["data"];
	if (empty($row)) return false;

	return SEO_set($row["title"], $row["keywords"], $row["description"]);
}


function SEO_set($title = "", $description = "", $keywords = "") {
	MSV_Log("Module:SEO -> Set: $title");
	
	$website = MSV_get("website");
	
	$website->page["title"] = $title;
	$website->page["keywords"] = $description;
	$website->page["description"] = $keywords;
	
	return true;
}


		
		
		