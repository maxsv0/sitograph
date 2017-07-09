<?php

function Feedback_Add($params, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($params["email"])) {
        $result["msg"] = _t("msg.feedback.noemail");
        return $result;
    } elseif (!MSV_checkEmail($params["email"])) {
        $result["msg"] = _t("msg.wrong_email");
        return $result;
    }
    if (empty($params["name"])) {
        $result["msg"] = _t("msg.feedback.noname");
        return $result;
    }

    // set defaults
    if (empty($params["sticked"])) {
        $params["sticked"] = 0;
    } else {
        $params["sticked"] = (int)$params["sticked"];
    }
    if (empty($params["published"])) {
        $params["published"] = 1;
    } else {
        $params["published"] = (int)$params["published"];
    }
    if (empty($params["date"])) {
        $params["date"] = date("Y-m-d H:i:s");
    }
    if (empty($params["stars"])) {
        $params["stars"] = 0;
    } else {
        $params["stars"] = (int)$params["stars"];
        if ($params["stars"] > 5 || $params["stars"] < 1) $params["stars"] = 0;
    }
    if (empty($params["ip"])) {
        $params["ip"] = MSV_GetIP();
    }

    // set empty fields
    if (empty($params["name_title"])) $params["name_title"] = "";
    if (empty($params["text"])) $params["text"] = "";
    if (empty($params["pic"])) $params["pic"] = "";

    $result = API_itemAdd(TABLE_FEEDBACK, $params);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.feedback.saved");

        // send email to $email
        // email template: feedback_notify
        if (in_array("EmailNotifyUser", $options)) {
            MSV_EmailTemplate("feedback_notify", $params["email"], $params);
        }

        // send email to "admin_email"
        // email template: feedback_admin_notify
        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = MSV_getConfig("admin_email");
            MSV_EmailTemplate("feedback_admin_notify", $emailAdmin, $params);
        }
    }

    return $result;
}