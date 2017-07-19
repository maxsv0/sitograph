<?php

/**
 * Add new blog article
 * Database table: TABLE_BLOG_ARTICLES
 * SEO is updated in case of success
 *
 * checks for required fields and correct values
 * $row["url"] is required
 * $row["title"] is required
 * $row["email"] is required
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: LoadPictures, EmailNotifyAdmin
 * @return array Result of a API call
 */
function msv_add_blog($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["url"])) {
        $result["msg"] = _t("msg.blog.nourl");
        return $result;
    }
    if (empty($row["title"])) {
        $result["msg"] = _t("msg.blog.notitle");
        return $result;
    }
    if (empty($row["email"])) {
        $result["msg"] = _t("msg.blog.noemail");
        return $result;
    }

    // set defaults
    if (empty($row["sticked"])) {
        $row["sticked"] = 0;
    } else {
        $row["sticked"] = (int)$row["sticked"];
    }
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }
    if (empty($row["date"])) {
        $row["date"] = date("Y-m-d H:i:s");
    }
    if (empty($row["album_id"])) {
        $row["album_id"] = 0;
    } else {
        $row["album_id"] = (int)$row["album_id"];
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
    if (empty($row["description"])) $row["description"] = "";
    if (empty($row["text"])) $row["text"] = "";
    if (empty($row["pic"])) $row["pic"] = "";
    if (empty($row["pic_preview"])) $row["pic_preview"] = "";

    if (in_array("LoadPictures", $options)) {
        // try to load files
        $row["pic"] = msv_process_uploadpic($row["pic"], TABLE_BLOG_ARTICLES, "pic");
        $row["pic_preview"] = msv_process_uploadpic($row["pic_preview"], TABLE_BLOG_ARTICLES, "pic_preview");
    }

    $result = db_add(TABLE_BLOG_ARTICLES, $row);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.blog.saved");

        $blog = msv_get("website.blog");

        $item = array(
            "url" => $blog->baseUrl.$row["url"]."/",
            "title" => $row["title"],
            "description" => $row["description"],
            "keywords" => $row["description"],
            "sitemap" => $row["published"],
        );

        msv_add_seo($item);

        $articleID = $result["insert_id"];

        // attach article categories
        if (!empty($row["category"]) && is_array($row["category"])) {
            foreach ($row["category"] as $itemCat) {
                $itemCat["published"] = 1;
                $itemCat["article_id"] = $articleID;

                $resultCat = db_add(TABLE_BLOG_ARTICLE_CATEGORIES, $itemCat);
                if (!$resultCat["ok"]) {
                    $result["msg"] .= $resultCat["msg"]."\n";
                }
            }
        }

        // send email to "admin_email"
        // email template: blog_admin_notify
        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = msv_get_config("admin_email");
            msv_email_template("blog_admin_notify", $emailAdmin, $row);
        }
    }
    return $result;
}
