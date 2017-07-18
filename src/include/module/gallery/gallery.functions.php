<?php

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
function Gallery_Add($row, $options = array()) {
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
        $row["pic"] = MSV_processUploadPic($row["pic"], TABLE_GALLERY_ALBUM, "pic");
        $row["pic_preview"] = MSV_processUploadPic($row["pic_preview"], TABLE_GALLERY_ALBUM, "pic_preview");
    }

    $result = API_itemAdd(TABLE_GALLERY_ALBUM, $row);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.gallery.saved");

        $gallery = MSV_get("website.gallery");

        $item = array(
            "url" => $gallery->baseUrl.$row["url"]."/",
            "title" => $row["title"],
            "description" => $row["description"],
            "keywords" => $row["description"],
            "sitemap" => $row["published"],
        );

        MSV_SEO_add($item);

        $albumID = $result["insert_id"];

        // attach album photos
        if (!empty($row["photos"]) && is_array($row["photos"])) {
            foreach ($row["photos"] as $itemPhoto) {
                $itemPhoto["published"] = 1;
                $itemPhoto["album_id"] = $albumID;

                if (in_array("LoadPictures", $options)) {
                    // try to load files
                    $itemPhoto["pic"] = MSV_processUploadPic($itemPhoto["pic"], TABLE_GALLERY_PHOTOS, "pic");
                    $itemPhoto["pic_preview"] = MSV_processUploadPic($itemPhoto["pic_preview"], TABLE_GALLERY_PHOTOS, "pic_preview");
                }
                $resultPhoto = API_itemAdd(TABLE_GALLERY_PHOTOS, $itemPhoto);
                if (!$resultPhoto["ok"]) {
                    $result["msg"] .= $resultPhoto["msg"]."\n";
                }
            }
        }
    }
    return $result;
}
