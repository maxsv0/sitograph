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
            "email" => $_REQUEST["feedback_email"],
            "name" => $_REQUEST["feedback_name"],
            "name_title" => $_REQUEST["feedback_name_title"],
            "text" => $_REQUEST["feedback_text"],
            "pic" => $_REQUEST["feedback_pic"],
            "stars" => $_REQUEST["feedback_stars"],
        );

        $result = Feedback_Add($item);
        if ($result["ok"]) {
            MSV_MessageOK($result["msg"]);
        } else {
            MSV_MessageError($result["msg"]);
        }
    }

    if (MSV_HasMessageError()) {
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

function Feedback_Add($params) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (!empty($params["email"])) {
        $email = $params["email"];
    } else {
        $result["msg"] = _t("msg.feedback.noemail");
        return $result;
    }
    if (!empty($params["name"])) {
        $name = $params["name"];
    } else {
        $result["msg"] = _t("msg.feedback.noname");
        return $result;
    }

    // set defaults
    if (!empty($params["sticked"])) {
        $sticked = (int)$params["sticked"];
    } else {
        $sticked = 0;
    }
    if (!empty($params["published"])) {
        $published = (int)$params["published"];
    } else {
        $published = 1;
    }
    if (!empty($params["date"])) {
        $date = $params["date"];
    } else {
        $date = date("Y-m-d H:i:s");
    }
    if (!empty($params["stars"])) {
        $stars = (int)$params["stars"];
        if ($stars > 5 || $stars < 1) $stars = 0;
    } else {
        $stars = 0;
    }

    // set empty fields
    if (empty($params["name_title"])) $params["name_title"] = "";
    if (empty($params["text"])) $params["text"] = "";
    if (empty($params["pic"])) $params["pic"] = "";

    $item = array(
        "published" => $published,
        "sticked" => $sticked,
        "date" => $date,
        "email" => $email,
        "name" => $name,
        "name_title" => $params["name_title"],
        "text" => $params["text"],
        "pic" => $params["pic"],
        "stars" => $stars,
        "ip" => MSV_GetIP(),
    );

    $result = API_itemAdd(TABLE_FEEDBACK, $item);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.feedback.saved");

        // send email to $email
        // email template: feedback_notify
        MSV_EmailTemplate("feedback_notify", $email, $item);

        // send email to "admin_email"
        // email template: feedback_admin_notify
        $emailAdmin = MSV_getConfig("admin_email");
        MSV_EmailTemplate("feedback_admin_notify", $emailAdmin, $item);
    }

    return $result;
}

function ajaxFeedbackRequest() {
    $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");
    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_FEEDBACK, "`sticked` > 0", "`date` desc", 999, "");
            break;
        case "add":
            $resultQuery = Feedback_Add($_REQUEST);
            if ($resultQuery["ok"]) {
                MSV_MessageOK($resultQuery["msg"]);
            } else {
                MSV_MessageError($resultQuery["msg"]);
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
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
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