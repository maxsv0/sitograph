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
function ajaxFeedbackRequest($module) {
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
                $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");
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
                $item = MSV_proccessTableData(TABLE_FEEDBACK, "");
                $resultQuery = Feedback_Add($item, array("EmailNotifyUser", "EmailNotifyAdmin"));
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
                    $resultQuery = API_updateDBItem(TABLE_FEEDBACK, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
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