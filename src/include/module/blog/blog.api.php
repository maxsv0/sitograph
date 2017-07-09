<?php

function ajaxBlogRequest($module) {
    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_BLOG_ARTICLES, "", "`date` desc", 999, "");
            break;
        case "category":
            $resultQuery = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, "", "", 999, "");
            break;
        case "details":
            $articleID = (int)$request[3];
            $resultQuery = API_getDBItem(TABLE_BLOG_ARTICLES, " id = '".$articleID."'");
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