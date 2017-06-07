<?php

function GalleryLoadPreview($gallery) {
	// Load list of albums
	$resultQuery = API_getDBList(TABLE_GALLERY_ALBUM, "", "views desc", $gallery->previewItemsCount);

	// Display message in case of error
	if (!$resultQuery["ok"]) {
		API_callError($resultQuery["msg"]);
		return false;
	} 
	
	// get a list of albums from API result
	$listItems = $resultQuery["data"];
	
	// create list if albums ID
	$listItemsID = array_keys($listItems);
	
	// Load photos for albums
	$resultPhotos = API_getDBList(TABLE_GALLERY_PHOTOS, " `album_id` IN (".implode(",",$listItemsID).")", "order_id asc");
	
	// Display message in case of error
	if (!$resultPhotos["ok"]) {
		API_callError($resultPhotos["msg"]);
		return false;
	} 
	
	// get a list of photos from API result
	$listAlbum = $resultPhotos["data"];
	
	// create list if albums
	$gallery_albums = array();
	foreach ($listItems as $item) {
		// add album to list
		$gallery_albums[$item["url"]] = $item;
		
		// add photos to album
		foreach ($listAlbum as $photo) {
			if ($photo["album_id"] !== $item["id"]) continue;
			$gallery_albums[$item["url"]]["photos"][] = $photo;
		}
	}

	// assign data to template
	MSV_assignData("gallery_albums_preview", $gallery_albums);
}


function GalleryLoad($gallery) {
	$sqlFilter = " 1 = 1 ";
	
    if (!empty($_GET[$gallery->searchUrlParam])) {
    	$arSearch = array("title", "description", "text", "url");
    	$sn = MSV_SQLEscape($_GET[$gallery->searchUrlParam]);

    	$sqlFilter .= " and ( ";
    	foreach ($arSearch as $v) {
    		$sqlFilter .= "$v like '%$sn%' or ";
    	}
    	$sqlFilter = substr($sqlFilter, 0, -3).") ";
    }
	
	
	// Load list of albums
	$resultQuery = API_getDBListPaged(TABLE_GALLERY_ALBUM, $sqlFilter, "`date` desc", $gallery->itemsPerPage, $gallery->pageUrlParam);

	// Display message in case of error
	if (!$resultQuery["ok"]) {
		API_callError($resultQuery["msg"]);
		return false;
	} 
	
	// get a list of albums from API result
	$listItems = $resultQuery["data"];
	
	// get a list of pages from API result
	$listPages = $resultQuery["pages"];
	
	$gallery_albums = array();
	if (!empty($listItems)) {
		// create list if albums ID
		$listItemsID = array();
		foreach ($listItems as $item) {
			$listItemsID[] = $item["id"];
		}
		
		// Load photos for albums
		$resultPhotos = API_getDBList(TABLE_GALLERY_PHOTOS, "album_id IN (".implode(",",$listItemsID).")", "order_id asc");
		
		// Display message in case of error
		if (!$resultPhotos["ok"]) {
			API_callError($resultPhotos["msg"]);
			return false;
		} 
		
		// get a list of photos from API result
		$listAlbum = $resultPhotos["data"];
		
		// create list if albums
		foreach ($listItems as $item) {
			// add album to list
			$gallery_albums[$item["url"]] = $item;
			
			// add photos to album
			foreach ($listAlbum as $photo) {
				if ($photo["album_id"] !== $item["id"]) continue;
				$gallery_albums[$item["url"]]["photos"][] = $photo;
			}
		}
	}

	// assign data to template
	MSV_assignData("gallery_albums", $gallery_albums);
	MSV_assignData("gallery_pages", $listPages);
}



function GalleryLoadAlbum($gallery) {
	$albumUrl = $gallery->website->requestUrlMatch[1];
	if (empty($albumUrl)) {
		API_callError("album Url not set");
		return false;
	}
	
	
	$result = API_getDBItem(TABLE_GALLERY_ALBUM, " url = '".$albumUrl."'");
	if (!$result["ok"]) {
		API_callError($result["msg"]);
		return false;
	} 
	$album = $result["data"];
	
	
	$resultAlbum = API_getDBList(TABLE_GALLERY_PHOTOS, "album_id = ".$album["id"], "order_id asc", 100000);
	if ($resultAlbum["ok"]) {
		$album["photos"] = $resultAlbum["data"];
	}

	// assign data to template
	MSV_assignData("gallery_album_details", $album);
	
	// update views / +1
	API_updateDBItem(TABLE_GALLERY_ALBUM, "views", "views+1", " url = '".$albumUrl."'");
	
	// add item to page nativation line
	MSV_setNavigation($album["title"], $album["url"]);
}



function GalleryInstall($module) {

	MSV_Structure_add("all", $module->baseUrl, "Gallery", "custom", "main-gallery.tpl", 1, "top", 10, "everyone");
	
}




function Gallery_Album_add($url, $album_date = "", $album_title = "", $album_description = "", $pic = "", $pic_preview = "", $views = 0, $shares = 0) {
	if (empty($album_date)) {
		$album_date = "NOW()";
	}
	
	// url for attached files
	$picPath = $picPathPreview = "";

	// save photo file
	if (!empty($pic)) {
		$fileResult = MSV_storePic($pic, "jpg", "", TABLE_GALLERY_ALBUM, "pic");
		
		// if result is number - some error occurred
		if (!is_numeric($fileResult)) {
			$picPath = $fileResult;
		}
	}
	
	// save preview file
	if (!empty($pic_preview)) {
		$fileResult = MSV_storePic($pic_preview, "jpg", "", TABLE_GALLERY_ALBUM, "pic_preview");
		
		// if result is number - some error occurred
		if (!is_numeric($fileResult)) {
			$picPathPreview = $fileResult;
		}
	}
	
	// prepare data for insertion
	$item = array(
		"published" => 1,
		"url" => $url,
		"date" => $album_date,
		"title" => $album_title,
		"description" => $album_description,
		"pic" => $picPath,
		"pic_preview" => $picPathPreview,
		"views" => $views,
		"shares" => $shares,
	);
	
	// add items to database
	$result = API_itemAdd(TABLE_GALLERY_ALBUM, $item);
	
	if ($result["ok"]) {
		$gallery = MSV_get("website.gallery");
		SEO_add($gallery->baseUrl.$url."/", $album_title, $album_title, $album_title, 1);
	}
	
	return $result;
}




function Gallery_Photo_add($album_id, $photo_date = "", $photo_title = "", $photo_description = "", $pic = "", $pic_preview = "") {
	if (empty($photo_date)) {
		$photo_date = "NOW()";
	}
	
	// url for attached files
	$picPath = $picPathPreview = "";
	
	// save photo file
	if (!empty($pic)) {
		$fileResult = MSV_storePic($pic, "jpg", "", TABLE_GALLERY_PHOTOS, "pic");
		
		// if result is number - some error occurred
		if (!is_numeric($fileResult)) {
			$picPath = $fileResult;
		}
	}
	
	// save preview file
	if (!empty($pic_preview)) {
		$fileResult = MSV_storePic($pic_preview, "jpg", "", TABLE_GALLERY_PHOTOS, "pic_preview");
		
		// if result is number - some error occurred
		if (!is_numeric($fileResult)) {
			$picPathPreview = $fileResult;
		}
	}

	// prepare data for insertion
	$item = array(
		"published" => 1,
		"album_id" => $album_id,
		"date" => $photo_date,
		"title" => $photo_title,
		"description" => $photo_description,
		"pic" => $picPath,
		"pic_preview" => $picPathPreview,
	);
	
	// add items to database
	$result = API_itemAdd(TABLE_GALLERY_PHOTOS, $item);
	
	if ($result["ok"]) {
		SEO_add("/gallery/".$url."/", $album_title, $album_title, $album_title, 1);
	}
	
	return $result;
}

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