<?php

/**
 * Register new user
 * Database table: TABLE_USERS
 *
 * checks for required fields and correct values
 * $row["email"] is required, has to be valid email and not used
 * unverified emails will receive link to confirm email
 * message will be generated in case if email was sent
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: EmailNotifyUser, EmailNotifyAdmin
 * @return array Result of a API call
 */
function msv_add_user($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["email"])) {
        $result["msg"] = _t("msg.users.noemail");
        return $result;
    } elseif (!msv_check_email($row["email"])) {
        $result["msg"] = _t("msg.wrong_email");
        return $result;
    }

    // check if user already exists
    $resultCheck = db_get(TABLE_USERS, " `email` = '".db_escape($row["email"])."'");
    if ($resultCheck["ok"] && !empty($resultCheck["data"])) {
        $result["msg"] = _t("msg.users.email_exists");
        return $result;
    }

    // set defaults
    if (empty($row["email_verified"])) {
        $row["email_verified"] = 0;
    } else {
        $row["email_verified"] = (int)$row["email_verified"];
    }
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }

    // set empty fields
    if (empty($row["password"])) {
        // do not allow empty password
        $row["password"] = msv_generate_password();
    }
    if (empty($row["access"])) $row["access"] = "user";
    if (empty($row["iss"])) $row["iss"] = "local";
    if (empty($row["name"])) $row["name"] = "";
    if (empty($row["phone"])) $row["phone"] = "";
    if (empty($row["pic"])) $row["pic"] = "";
    if (empty($row["verify_token"])) $row["verify_token"] = "";
    if (empty($row["access_token"])) $row["access_token"] = "";
    if (empty($row["email_verified"])) {
        $row["verify_token"] = substr(md5(microtime().rand()), 0, 10);
    }

    // replace password with hash
    $row["password_orig"] = $row["password"];
    if (USER_HASH_PASSWORD) {
        $row["password"] = password_hash($row["password"], PASSWORD_DEFAULT);
    }

    // assign user to each language (*)
    $result = db_add(TABLE_USERS, $row, "*");

    if ($result["ok"]) {
        $result["msg"] = _t("msg.users.reg_success");

        $userInfo = $row;
        $userInfo["password"] = $userInfo["password_orig"];
        $userInfo["verify_link"] = HOME_URL."settings/?verify_token=".$userInfo["verify_token"];

        if (in_array("EmailNotifyUser", $options)) {
            if ($row["email_verified"] > 0) {
                $resultMail = msv_email_template("user_registration", $userInfo["email"], $userInfo);
            } else {
                $resultMail = msv_email_template("user_registration_verify", $userInfo["email"], $userInfo);
            }
            if ($resultMail) {
                msv_message_ok(_t("msg.email_sent_to")." <b>".$userInfo["email"]."</b>");
            } else {
                msv_message_error(_t("msg.email_sending_error"));
            }
        }

        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = msv_get_config("admin_email");
            msv_email_template("user_registration_notify", $emailAdmin, $userInfo);
        }
    }

    return $result;
}

/**
 * Register user session
 * update $_SESSION to save user_id
 * add user row to $website->user
 *
 * @param integer $userID
 * @param bool $session register user at session?
 * @return null
 */
function msv_load_user($userID, $session = true) {
    $rowUser =& msv_get("website.user");

    $result = db_get(TABLE_USERS, " `id` = '".(int)$userID."' and `access` != 'closed'");
    if (!$result["ok"]) {
        msv_message_error($result["msg"]);
    } else {
        // TODO: why this is needed?
        $rowUser["user_id"] = (int)$userID;

        // add info to user row
        $rowUser = array_merge($rowUser, $result["data"]);
    }

    if ($session) {
        $_SESSION["user_id"] = $userID;
        $_SESSION["user_email"] = $rowUser["email"];
    }
    if (empty($rowUser["email_verified"])) {
        msv_message_error(_t("msg.users.verification_needed"));
    }
}