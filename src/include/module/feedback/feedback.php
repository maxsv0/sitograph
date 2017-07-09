<?php
// admin user features
MSV_addAdminEdit(".feedbackItem", "feedback", TABLE_FEEDBACK);

if (!empty($_REQUEST["doSendFeedback"])) {
    // extract data from request for corresponding table
    $item = MSV_proccessTableData(TABLE_FEEDBACK, "feedback_");

    // execute request
    $result = Feedback_Add($item, array("EmailNotifyUser", "EmailNotifyAdmin"));
    if ($result["ok"]) {
        MSV_MessageOK($result["msg"]);
    } else {
        MSV_MessageError($result["msg"]);
    }

    if (MSV_HasMessageError()) {
        // pass data from request to template to autofill the form
        MSV_assignTableData(TABLE_FEEDBACK, "feedback_");
    }
}

function loadFeedback($module) {
    // load 'sticked' items from feedback table
    $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", $module->stickedItemsCount, "");
    if ($resultQuery["ok"]) {
        // get a list of items from API result
        $listItems = $resultQuery["data"];
        // assign data to template
        MSV_assignData("feedback_sticked", $listItems);
    }
}
