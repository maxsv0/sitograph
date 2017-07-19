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
function api_request_blog($module) {
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
                $resultQuery = db_get_list(TABLE_BLOG_ARTICLES, "", "`date` desc", 999, "");
            }
            break;
        case "category":
            if (!msv_check_accessuser($module->accessAPICategory)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $resultQuery = db_get_list(TABLE_BLOG_ARTICLE_CATEGORIES, "", "", 999, "");
            }
            break;
        case "details":
            if (!msv_check_accessuser($module->accessAPIDetails)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "No access",
                );
            } else {
                $articleID = (int)$request[3];
                $resultQuery = db_get(TABLE_BLOG_ARTICLES, " id = '".$articleID."'");
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
                $item = msv_process_tabledata(TABLE_BLOG_ARTICLES, "");
                $resultQuery = msv_add_blog($item, array("LoadPictures", "EmailNotifyAdmin"));
            }
            break;
        case "edit":
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
                    $resultQuery = db_update(TABLE_BLOG_ARTICLES, $_REQUEST["updateName"], "'".db_escape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
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