<?php

/**
 * API extension for module gallery
 *
 * Allow URLs like:
 * 		/api/gallery/list/			=> access: accessAPIList
 * 		/api/gallery/album/12345/	=> access: accessAPIAlbum
 * 		/api/gallery/add/			=> access: accessAPIAdd
 * 		/api/gallery/edit-album/	=> access: accessAPIEdit
 * 		/api/gallery/edit-photo/	=> access: accessAPIEdit
 *
 * @param object $module Current module object
 * @return string JSON encoded string containing API call result
 */
function ajaxGalleryRequest($module) {

    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            if (!MSV_checkAccessUser($module->accessAPIList)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $resultQuery = API_getDBList(TABLE_GALLERY_ALBUM, "", "`date` desc", 999, "");
            }
            break;
        case "album":
            if (!MSV_checkAccessUser($module->accessAPIAlbum)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $albumID = (int)$request[3];
                $resultQuery = API_getDBList(TABLE_GALLERY_PHOTOS, "`album_id` = ".$albumID, "`date` desc", 999, "");
            }
            break;
        case "add":
            if (!MSV_checkAccessUser($module->accessAPIAdd)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $item = MSV_proccessTableData(TABLE_GALLERY_ALBUM, "");
                $resultQuery = Gallery_Add($item, array("LoadPictures"));
            }
            break;
        case "edit-album":
            if (!MSV_checkAccessUser($module->accessAPIEdit)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                    $resultQuery = array(
                        "ok" => false,
                        "data" => array(),
                        "msg" => "Wrong Input",
                    );
                } else {
                    $resultQuery = API_updateDBItem(TABLE_GALLERY_ALBUM, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
                }
            }
            break;
        case "edit-photo":
            if (!MSV_checkAccessUser($module->accessAPIEdit)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                    $resultQuery = array(
                        "ok" => false,
                        "data" => array(),
                        "msg" => "Wrong Input",
                    );
                } else {
                    $resultQuery = API_updateDBItem(TABLE_GALLERY_PHOTOS, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
                }
            }
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