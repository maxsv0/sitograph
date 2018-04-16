<?php

/**
 * API extension for module feedback
 *
 * Allow URLs like:
 * 		/api/feedback/list/		=> access: accessAPIList
 * 		/api/feedback/add/		=> access: accessAPIAdd
 * 		/api/feedback/edit/		=> access: accessAPIEdit
 *
 * @param object $module Current module object
 * @return string JSON encoded string containing API call result
 */
function api_request_feedback($module) {
    $request = msv_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            if (!msv_check_accessuser($module->accessAPIList)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => _t("msg.api.no_access"),
                );
            } else {
                $resultQuery = db_get_list(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");
            }
            break;
        case "add":
            if (!msv_check_accessuser($module->accessAPIAdd)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => _t("msg.api.no_access"),
                );
            } else {
                $item = msv_process_tabledata(TABLE_FEEDBACK, "");
                $resultQuery = msv_add_feedback($item, array("EmailNotifyUser", "EmailNotifyAdmin"));
            }
            break;
        case "edit":
            if (!msv_check_accessuser($module->accessAPIEdit)) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => _t("msg.api.no_access"),
                );
            } else {
                if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                    $resultQuery = array(
                        "ok" => false,
                        "data" => array(),
                        "msg" => _t("msg.api.wrong_api"),
                    );
                } else {
                    $resultQuery = db_update(TABLE_FEEDBACK, $_REQUEST["updateName"], "'".db_escape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
                }
            }
            break;
        default:
            $resultQuery = array(
                "ok" => false,
                "data" => array(),
                "msg" => _t("msg.api.wrong_api"),
            );
            break;
    }

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}