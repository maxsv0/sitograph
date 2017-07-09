<?php

function ajaxFeedbackRequest() {
    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");
            break;
        case "add":
            $item = MSV_proccessTableData(TABLE_FEEDBACK, "");
            $resultQuery = Feedback_Add($item, array("EmailNotifyUser", "EmailNotifyAdmin"));
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