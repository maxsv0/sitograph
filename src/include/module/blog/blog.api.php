<?php

/**
 * API extension for module blog
 *
 * Allow URLs like:
 * 		/api/blog/list/				=> access: accessAPIList
 * 		/api/blog/category/			=> access: accessAPICategory
 * 		/api/blog/details/12345/	=> access: accessAPIDetails
 * 		/api/blog/add/				=> access: accessAPIAdd
 * 		/api/blog/edit/				=> access: accessAPIEdit
 *
 * @param object $module Current module object
 * @return string JSON encoded string containing API call result
 */
function ajaxBlogRequest($module) {
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
                $resultQuery = API_getDBList(TABLE_BLOG_ARTICLES, "", "`date` desc", 999, "");
            }
            break;
        case "category":
            if (!MSV_checkAccessUser($module->accessAPICategory)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $resultQuery = API_getDBList(TABLE_BLOG_ARTICLE_CATEGORIES, "", "", 999, "");
            }
            break;
        case "details":
            if (!MSV_checkAccessUser($module->accessAPIDetails)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $articleID = (int)$request[3];
                $resultQuery = API_getDBItem(TABLE_BLOG_ARTICLES, " id = '".$articleID."'");
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
                $item = MSV_proccessTableData(TABLE_BLOG_ARTICLES, "");
                $resultQuery = Blog_add($item, array("LoadPictures", "EmailNotifyAdmin"));
            }
            break;
        case "edit":
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
                    $resultQuery = API_updateDBItem(TABLE_BLOG_ARTICLES, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
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