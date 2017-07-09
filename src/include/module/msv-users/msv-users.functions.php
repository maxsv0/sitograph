<?php

function User_Add($params, $doEmailNotify = false, $doEmailNotifyAdmin = false) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($params["email"])) {
        $result["msg"] = _t("msg.users.noemail");
        return $result;
    } elseif (!MSV_checkEmail($params["email"])) {
        $result["msg"] = _t("msg.wrong_email");
        return $result;
    }

    // check if user already exists
    $resultCheck = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($params["email"])."'");
    if ($resultCheck["ok"] && !empty($resultCheck["data"])) {
        $result["msg"] = _t("msg.users.email_exists");
        return $result;
    }

    // set defaults
    if (!empty($params["email_verified"])) {
        $params["email_verified"] = (int)$params["email_verified"];
    } else {
        $params["email_verified"] = 0;
    }
    if (!empty($params["published"])) {
        $params["published"] = (int)$params["published"];
    } else {
        $params["published"] = 1;
    }

    // set empty fields
    if (empty($params["password"])) {
        // do not allow empty password
        $params["password"] = MSV_PasswordGenerate();
    }
    if (empty($params["access"])) $params["access"] = "user";
    if (empty($params["iss"])) $params["iss"] = "local";
    if (empty($params["name"])) $params["name"] = "";
    if (empty($params["phone"])) $params["phone"] = "";
    if (empty($params["pic"])) $params["pic"] = "";
    if (empty($params["verify_token"])) $params["verify_token"] = "";
    if (empty($params["access_token"])) $params["access_token"] = "";
    if (empty($params["email_verified"])) {
        $params["verify_token"] = substr(md5(microtime().rand()), 0, 10);
    }

    // replace password with hash
    $params["password_orig"] = $params["password"];
    if (USER_HASH_PASSWORD) {
        $params["password"] = password_hash($params["password"], PASSWORD_DEFAULT);
    }

    // assign user to each language (*)
    $result = API_itemAdd(TABLE_USERS, $params, "*");

    if ($result["ok"]) {
        $userInfo = $params;
        $userInfo["password"] = $userInfo["password_orig"];
        $userInfo["verify_link"] = HOME_URL."settings/?verify_token=".$userInfo["verify_token"];

        if ($doEmailNotify) {
            if ($params["email_verified"] > 0) {
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

        if ($doEmailNotifyAdmin) {
            $emailAdmin = MSV_getConfig("admin_email");
            MSV_EmailTemplate("user_registration_notify", $emailAdmin, $userInfo);
        }
    }

    return $result;
}
