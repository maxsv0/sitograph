<?php

function Gallery_Add($params, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($params["url"])) {
        $result["msg"] = _t("msg.gallery.nourl");
        return $result;
    }
    if (empty($params["title"])) {
        $result["msg"] = _t("msg.gallery.notitle");
        return $result;
    }

    // set defaults
    if (empty($params["published"])) {
        $params["published"] = 1;
    } else {
        $params["published"] = (int)$params["published"];
    }
    if (empty($params["date"])) {
        $params["date"] = date("Y-m-d H:i:s");
    }
    if (empty($params["views"])) {
        $params["views"] = 0;
    } else {
        $params["views"] = (int)$params["views"];
    }
    if (empty($params["shares"])) {
        $params["shares"] = 0;
    } else {
        $params["shares"] = (int)$params["shares"];
    }
    if (empty($params["comments"])) {
        $params["comments"] = 0;
    } else {
        $params["comments"] = (int)$params["comments"];
    }

    // set empty fields
    if (empty($params["description"])) $params["description"] = "";
    if (empty($params["pic"])) $params["pic"] = "";
    if (empty($params["pic_preview"])) $params["pic_preview"] = "";

    if (in_array("LoadPictures", $options)) {
        // try to load files
        if (!empty($params["pic"]) && is_readable(UPLOAD_FILES_PATH."/".$params["pic"])) {
            $fileResult = MSV_storePic(UPLOAD_FILES_PATH."/".$params["pic"], "jpg", "", TABLE_GALLERY_ALBUM, "pic");
            if (!is_numeric($fileResult)) {
                $params["pic"] = $fileResult;
            }
        }
        if (!empty($params["pic_preview"]) && is_readable(UPLOAD_FILES_PATH."/".$params["pic_preview"])) {
            $fileResult = MSV_storePic(UPLOAD_FILES_PATH."/".$params["pic_preview"], "jpg", "", TABLE_GALLERY_ALBUM, "pic_preview");
            if (!is_numeric($fileResult)) {
                $params["pic_preview"] = $fileResult;
            }
        }
    }

    $result = API_itemAdd(TABLE_GALLERY_ALBUM, $params);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.gallery.saved");

        $gallery = MSV_get("website.gallery");

        $item = array(
            "url" => $gallery->baseUrl.$params["url"]."/",
            "title" => $params["title"],
            "description" => $params["description"],
            "keywords" => $params["description"],
            "sitemap" => $params["published"],
        );

        SEO_add($item);

        $albumID = $result["insert_id"];
        if (!empty($params["photos"]) && is_array($params["photos"])) {
            foreach ($params["photos"] as $itemPhoto) {
                $itemPhoto["published"] = 1;
                $itemPhoto["album_id"] = $albumID;

                if (in_array("LoadPictures", $options)) {
                    // try to load files
                    if (!empty($itemPhoto["pic"]) && is_readable(UPLOAD_FILES_PATH . "/" . $itemPhoto["pic"])) {
                        $fileResult = MSV_storePic(UPLOAD_FILES_PATH . "/" . $itemPhoto["pic"], "jpg", "", TABLE_GALLERY_PHOTOS, "pic");
                        if (!is_numeric($fileResult)) {
                            $itemPhoto["pic"] = $fileResult;
                        }
                    }
                    if (!empty($itemPhoto["pic_preview"]) && is_readable(UPLOAD_FILES_PATH . "/" . $itemPhoto["pic_preview"])) {
                        $fileResult = MSV_storePic(UPLOAD_FILES_PATH . "/" . $itemPhoto["pic_preview"], "jpg", "", TABLE_GALLERY_PHOTOS, "pic_preview");
                        if (!is_numeric($fileResult)) {
                            $itemPhoto["pic_preview"] = $fileResult;
                        }
                    }
                }
                $resultPhoto = API_itemAdd(TABLE_GALLERY_PHOTOS, $itemPhoto);
                if (!$resultPhoto["ok"]) {
                    MSV_MessageError($resultPhoto["msg"]);
                }
            }
        }
    }
    return $result;
}
