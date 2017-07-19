<?php
// admin user features
msv_admin_editbtn(".feedbackItem", "feedback", TABLE_FEEDBACK);

if (!empty($_REQUEST["doSendFeedback"])) {
    // extract data from request for corresponding table
    $item = msv_process_tabledata(TABLE_FEEDBACK, "feedback_");

    // execute request
    $result = msv_add_feedback($item, array("EmailNotifyUser", "EmailNotifyAdmin"));
    if ($result["ok"]) {
        msv_message_ok($result["msg"]);
    } else {
        msv_message_error($result["msg"]);
    }

    if (msv_has_messages()) {
        // pass data from request to template to autofill the form
        msv_assign_tabledata(TABLE_FEEDBACK, "feedback_");
    }
}

function loadFeedback($module) {
    // load 'sticked' items from feedback table
    $resultQuery = db_get_list(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", $module->stickedItemsCount, "");
    if ($resultQuery["ok"]) {
        // get a list of items from API result
        $listItems = $resultQuery["data"];
        // assign data to template
        msv_assign_data("feedback_sticked", $listItems);
    }
}
