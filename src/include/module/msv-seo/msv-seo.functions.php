<?php

function SEO_add($params, $lang = LANG) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($params["url"])) {
        $result["msg"] = _t("msg.seo.nourl");
        return $result;
    }

    // set defaults
    if (empty($params["sitemap"])) {
        $params["sitemap"] = 0;
    } else {
        $params["sitemap"] = (int)$params["sitemap"];
    }
    if (empty($params["published"])) {
        $params["published"] = 1;
    } else {
        $params["published"] = (int)$params["published"];
    }

    // set empty fields
    if (empty($params["title"])) $params["title"] = "";
    if (empty($params["description"])) $params["description"] = "";
    if (empty($params["keywords"])) $params["keywords"] = "";

    $result = API_itemAdd(TABLE_SEO, $params, $lang);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.seo.saved");
    }

    return $result;
}
