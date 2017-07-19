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
function api_request_gallery($module) {

    $request = msv_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            if (!msv_check_accessuser($module->accessAPIList)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $resultQuery = db_get_list(TABLE_GALLERY_ALBUM, "", "`date` desc", 999, "");
            }
            break;
        case "album":
            if (!msv_check_accessuser($module->accessAPIAlbum)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $albumID = (int)$request[3];
                $resultQuery = db_get_list(TABLE_GALLERY_PHOTOS, "`album_id` = ".$albumID, "`date` desc", 999, "");
            }
            break;
        case "add":
            if (!msv_check_accessuser($module->accessAPIAdd)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $item = msv_process_tabledata(TABLE_GALLERY_ALBUM, "");
                $resultQuery = msv_add_gallery($item, array("LoadPictures"));
            }
            break;
        case "edit-album":
            if (!msv_check_accessuser($module->accessAPIEdit)) {
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
                    $resultQuery = db_update(TABLE_GALLERY_ALBUM, $_REQUEST["updateName"], "'".db_escape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
                }
            }
            break;
        case "edit-photo":
            if (!msv_check_accessuser($module->accessAPIEdit)) {
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
                    $resultQuery = db_update(TABLE_GALLERY_PHOTOS, $_REQUEST["updateName"], "'".db_escape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
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