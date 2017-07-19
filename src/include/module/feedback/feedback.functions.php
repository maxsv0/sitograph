<?php

/**
 * Adds new feedback post
 * Database table: TABLE_FEEDBACK
 *
 * checks for required fields and correct values
 * $row["email"] is required, has to be valid email
 * $row["name"] is required
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: EmailNotifyUser, EmailNotifyAdmin
 * @return array Result of a API call
 */
function msv_add_feedback($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["email"])) {
        $result["msg"] = _t("msg.feedback.noemail");
        return $result;
    } elseif (!msv_check_email($row["email"])) {
        $result["msg"] = _t("msg.wrong_email");
        return $result;
    }
    if (empty($row["name"])) {
        $result["msg"] = _t("msg.feedback.noname");
        return $result;
    }

    // set defaults
    if (empty($row["sticked"])) {
        $row["sticked"] = 0;
    } else {
        $row["sticked"] = (int)$row["sticked"];
    }
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }
    if (empty($row["date"])) {
        $row["date"] = date("Y-m-d H:i:s");
    }
    if (empty($row["stars"])) {
        $row["stars"] = 0;
    } else {
        $row["stars"] = (int)$row["stars"];
        if ($row["stars"] > 5 || $row["stars"] < 1) $row["stars"] = 0;
    }
    if (empty($row["ip"])) {
        $row["ip"] = msv_get_ip();
    }

    // set empty fields
    if (empty($row["name_title"])) $row["name_title"] = "";
    if (empty($row["text"])) $row["text"] = "";
    if (empty($row["pic"])) $row["pic"] = "";

    $result = db_add(TABLE_FEEDBACK, $row);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.feedback.saved");

        // send email to $email
        // email template: feedback_notify
        if (in_array("EmailNotifyUser", $options)) {
            msv_email_template("feedback_notify", $row["email"], $row);
        }

        // send email to "admin_email"
        // email template: feedback_admin_notify
        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = msv_get_config("admin_email");
            msv_email_template("feedback_admin_notify", $emailAdmin, $row);
        }
    }

    return $result;
}