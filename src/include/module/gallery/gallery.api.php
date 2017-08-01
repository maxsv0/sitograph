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
                $resultQuery = api_gallery_add($item, array("LoadPictures"));
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

/**
 * Add new album with photos
 * Database table: TABLE_GALLERY_ALBUM, TABLE_GALLERY_PHOTOS
 * SEO is updated in case of success
 *
 * checks for required fields and correct values
 * $row["url"] is required
 * $row["photos"] is a list of photos for album
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: LoadPictures
 * @return array Result of a API call
 */
function api_gallery_add($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["url"])) {
        $result["msg"] = _t("msg.gallery.nourl");
        return $result;
    }

    // set defaults
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }
    if (empty($row["date"])) {
        $row["date"] = date("Y-m-d H:i:s");
    }
    if (empty($row["views"])) {
        $row["views"] = 0;
    } else {
        $row["views"] = (int)$row["views"];
    }
    if (empty($row["shares"])) {
        $row["shares"] = 0;
    } else {
        $row["shares"] = (int)$row["shares"];
    }
    if (empty($row["comments"])) {
        $row["comments"] = 0;
    } else {
        $row["comments"] = (int)$row["comments"];
    }

    // set empty fields
    if (empty($row["title"])) $row["title"] = "";
    if (empty($row["description"])) $row["description"] = "";
    if (empty($row["pic"])) $row["pic"] = "";
    if (empty($row["pic_preview"])) $row["pic_preview"] = "";

    if (in_array("LoadPictures", $options)) {
        // try to load files
        $row["pic"] = msv_process_uploadpic($row["pic"], TABLE_GALLERY_ALBUM, "pic");
        $row["pic_preview"] = msv_process_uploadpic($row["pic_preview"], TABLE_GALLERY_ALBUM, "pic_preview");
    }

    $result = db_add(TABLE_GALLERY_ALBUM, $row);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.gallery.saved");

        $gallery = msv_get("website.gallery");

        $item = array(
            "url" => $gallery->baseUrl.$row["url"]."/",
            "title" => $row["title"],
            "description" => $row["description"],
            "keywords" => $row["description"],
            "sitemap" => $row["published"],
        );

        msv_add_seo($item);

        $albumID = $result["insert_id"];

        // attach album photos
        if (!empty($row["photos"]) && is_array($row["photos"])) {
            foreach ($row["photos"] as $itemPhoto) {
                $itemPhoto["published"] = 1;
                $itemPhoto["album_id"] = $albumID;

                if (in_array("LoadPictures", $options)) {
                    // try to load files
                    $itemPhoto["pic"] = msv_process_uploadpic($itemPhoto["pic"], TABLE_GALLERY_PHOTOS, "pic");
                    $itemPhoto["pic_preview"] = msv_process_uploadpic($itemPhoto["pic_preview"], TABLE_GALLERY_PHOTOS, "pic_preview");
                }
                $resultPhoto = db_add(TABLE_GALLERY_PHOTOS, $itemPhoto);
                if (!$resultPhoto["ok"]) {
                    $result["msg"] .= $resultPhoto["msg"]."\n";
                }
            }
        }
    }
    return $result;
}
