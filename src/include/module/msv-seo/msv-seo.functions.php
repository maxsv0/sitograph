<?php

/**
 * Add new SEO item
 * Database table: TABLE_SEO
 *
 * checks for required fields and correct values
 * $row["url"] is required
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: lang
 * @return array Result of a API call
 */
function SEO_add($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["url"])) {
        $result["msg"] = _t("msg.seo.nourl");
        return $result;
    }

    // set defaults
    if (empty($row["sitemap"])) {
        $row["sitemap"] = 0;
    } else {
        $row["sitemap"] = (int)$row["sitemap"];
    }
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }
    if (!empty($options["lang"])) {
        $lang = $options["lang"];
    } else {
        $lang = LANG;
    }

    // set empty fields
    if (empty($row["title"])) $row["title"] = "";
    if (empty($row["description"])) $row["description"] = "";
    if (empty($row["keywords"])) $row["keywords"] = "";

    $result = API_itemAdd(TABLE_SEO, $row, $lang);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.seo.saved");
    }

    return $result;
}
