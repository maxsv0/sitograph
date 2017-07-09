<?php
// admin user features
MSV_addAdminEdit(".galleryAlbum", "gallery", TABLE_GALLERY_ALBUM);

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
