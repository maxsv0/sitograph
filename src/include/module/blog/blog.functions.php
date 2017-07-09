<?php

function Blog_add($params, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($params["url"])) {
        $result["msg"] = _t("msg.blog.nourl");
        return $result;
    }
    if (empty($params["title"])) {
        $result["msg"] = _t("msg.blog.notitle");
        return $result;
    }
    if (empty($params["email"])) {
        $result["msg"] = _t("msg.blog.noemail");
        return $result;
    }

    // set defaults
    if (empty($params["sticked"])) {
        $params["sticked"] = 0;
    } else {
        $params["sticked"] = (int)$params["sticked"];
    }
    if (empty($params["published"])) {
        $params["published"] = 1;
    } else {
        $params["published"] = (int)$params["published"];
    }
    if (empty($params["date"])) {
        $params["date"] = date("Y-m-d H:i:s");
    }
    if (empty($params["album_id"])) {
        $params["album_id"] = 0;
    } else {
        $params["album_id"] = (int)$params["album_id"];
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
    if (empty($params["text"])) $params["text"] = "";
    if (empty($params["pic"])) $params["pic"] = "";
    if (empty($params["pic_preview"])) $params["pic_preview"] = "";

    if (in_array("LoadPictures", $options)) {
        // try to load files
        if (!empty($params["pic"]) && is_readable(UPLOAD_FILES_PATH."/".$params["pic"])) {
            $fileResult = MSV_storePic(UPLOAD_FILES_PATH."/".$params["pic"], "jpg", "", TABLE_BLOG_ARTICLES, "pic");
            if (!is_numeric($fileResult)) {
                $params["pic"] = $fileResult;
            } else {
                $params["pic"] = "";
            }
        } else {
            $params["pic"] = "";
        }
        if (!empty($params["pic_preview"]) && is_readable(UPLOAD_FILES_PATH."/".$params["pic_preview"])) {
            $fileResult = MSV_storePic(UPLOAD_FILES_PATH."/".$params["pic_preview"], "jpg", "", TABLE_BLOG_ARTICLES, "pic_preview");
            if (!is_numeric($fileResult)) {
                $params["pic_preview"] = $fileResult;
            } else {
                $params["pic_preview"] = "";
            }
        } else{
            $params["pic_preview"] = "";
        }
    }

    $result = API_itemAdd(TABLE_BLOG_ARTICLES, $params);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.blog.saved");

        $blog = MSV_get("website.blog");

        $item = array(
            "url" => $blog->baseUrl.$params["url"]."/",
            "title" => $params["title"],
            "description" => $params["description"],
            "keywords" => $params["description"],
            "sitemap" => $params["published"],
        );

        SEO_add($item);

        // send email to "admin_email"
        // email template: blog_admin_notify
        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = MSV_getConfig("admin_email");
            MSV_EmailTemplate("blog_admin_notify", $emailAdmin, $params);
        }
    }
    return $result;
}
