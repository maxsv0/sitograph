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
function User_Add($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["email"])) {
        $result["msg"] = _t("msg.users.noemail");
        return $result;
    } elseif (!MSV_checkEmail($row["email"])) {
        $result["msg"] = _t("msg.wrong_email");
        return $result;
    }

    // check if user already exists
    $resultCheck = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($row["email"])."'");
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
        $row["password"] = MSV_PasswordGenerate();
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
    $result = API_itemAdd(TABLE_USERS, $row, "*");

    if ($result["ok"]) {
        $result["msg"] = _t("msg.users.reg_success");

        $userInfo = $row;
        $userInfo["password"] = $userInfo["password_orig"];
        $userInfo["verify_link"] = HOME_URL."settings/?verify_token=".$userInfo["verify_token"];

        if (in_array("EmailNotifyUser", $options)) {
            if ($row["email_verified"] > 0) {
                $resultMail = MSV_EmailTemplate("user_registration", $userInfo["email"], $userInfo);
            } else {
                $resultMail = MSV_EmailTemplate("user_registration_verify", $userInfo["email"], $userInfo);
            }
            if ($resultMail) {
                MSV_MessageOK(_t("msg.email_sent_to")." <b>".$userInfo["email"]."</b>");
            } else {
                MSV_MessageError(_t("msg.email_sending_error"));
            }
        }

        if (in_array("EmailNotifyAdmin", $options)) {
            $emailAdmin = MSV_getConfig("admin_email");
            MSV_EmailTemplate("user_registration_notify", $emailAdmin, $userInfo);
        }
    }

    return $result;
}
