<?php

if (!empty($_REQUEST["doSendFeedback"])) {
    if (empty($_REQUEST["feedback_email"])) {
        MSV_MessageError(_t("msg.feedback.noemail"));
    }
    if (empty($_REQUEST["feedback_name"])) {
        MSV_MessageError(_t("msg.feedback.noname"));
    }

    if (!MSV_HasMessageError()) {
        if (!empty($_FILES["feedback_pic"]) && !empty($_FILES["feedback_pic"]["name"])) {
            // save user picture
            $fileResult = MSV_storePic($_FILES["feedback_pic"]["tmp_name"], $_FILES["feedback_pic"]["type"], "", TABLE_FEEDBACK, "pic");

            // if result is number - some error occurred
            if (!is_numeric($fileResult)) {
                $_REQUEST["feedback_pic"] = $fileResult;
            }
        }
    }

    if (!MSV_HasMessageError()) {
        $item = array(
            "published" => 1,
            "sticked" => 0,
            "date" => date("Y-m-d H:i:s"),
            "email" => $_REQUEST["feedback_email"],
            "name" => $_REQUEST["feedback_name"],
            "name_title" => $_REQUEST["feedback_name_title"],
            "text" => $_REQUEST["feedback_text"],
            "pic" => $_REQUEST["feedback_pic"],
            "stars" => $_REQUEST["feedback_stars"],
            "ip" => MSV_GetIP(),
        );

        $result = API_itemAdd(TABLE_FEEDBACK, $item);

        if ($result["ok"]) {
            MSV_MessageOK(_t("msg.feedback.saved"));

            // send email to $_REQUEST["feedback_email"]
            // email template: feedback_notify
            MSV_EmailTemplate("feedback_notify", $_REQUEST["feedback_email"], $item, false);

            // send email to "admin_email"
            // email template: feedback_admin_notify
            $emailAdmin = MSV_getConfig("admin_email");
            MSV_EmailTemplate("feedback_admin_notify", $emailAdmin, $item, false);
        } else {
            MSV_MessageError($result["msg"]);
        }
    } else {
        // pass data from REQUEST to template to autofill the form
        MSV_assignTableData(TABLE_FEEDBACK, "feedback");
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

function ajaxFeedbackRequest() {
    $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}

function FeedbackInstall($module) {
    // install website page with feedback form
    MSV_Structure_add("all", $module->baseUrl, "Feedback", "custom", "main-feedback.tpl", 1, "", 0, "everyone");

    // add Email Templates
    $templateFeedbackNotify = '
You are receiving this email because we received a new feedback request from your account. 
<br />
Feedback details:<br />
Email: <strong>{email}</strong><br /> 
Name: <strong>{name}</strong> <br /> 
Name Title: <strong>{name_title}</strong> <br /> 
Date: <strong>{date}</strong> <br /> 
IP: <strong>{ip}</strong> <br /> 
Text: <br /> 
{text}<br /> 
<br /><br /> 
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';
    MSV_MailTemplate_add("feedback_notify", "Your support ticket was received", $templateFeedbackNotify, "", "all");

    $templateFeedbackNotifyAdmin = '
Feedback details:<br />
Email: <strong>{email}</strong><br /> 
Name: <strong>{name}</strong> <br /> 
Name Title: <strong>{name_title}</strong> <br /> 
Date: <strong>{date}</strong> <br /> 
IP: <strong>{ip}</strong> <br /> 
Text: <br /> 
{text}<br /> 
';
    MSV_MailTemplate_add("feedback_admin_notify", "New support ticket was received", $templateFeedbackNotifyAdmin, "", "all");
}