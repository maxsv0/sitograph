<?php

function ajaxGalleryRequest($module) {

	$request = MSV_get('website.requestUrlMatch');
	$apiType = $request[2];
	
	switch ($apiType) {
		case "list":
			$resultQuery = API_getDBList(TABLE_GALLERY_ALBUM, "", "`date` desc", 999, "");
			break;
		case "album":
			$albumID = (int)$request[3];
			$resultQuery = API_getDBList(TABLE_GALLERY_PHOTOS, "`album_id` = ".$albumID, "`date` desc", 999, "");
			break;
		default:
			$resultQuery = array(
		        "ok" => false,
		        "data" => array(),
		        "msg" => "Wrong API call",
		    );
			break;
	}
	
	// do not output sql for security reasons
	unset($resultQuery["sql"]);
	
	// output result as JSON
    return json_encode($resultQuery);
}