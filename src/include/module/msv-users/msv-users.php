<?php
// handle logout link
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
}

// add message to page
if (isset($_REQUEST['registered'])) {
    MSV_MessageOK(_t("msg.users.reg_success"));
}

// load user info, if session already registered
if (!empty($_SESSION["user_id"])) {
    MSV_userLoad($_SESSION["user_id"]);
}

// handle email verify link
// load user session using $_REQUEST["verify_token"]
// directly access user account and register session
if (!empty($_REQUEST["verify_token"])) {
    $result = API_getDBItem(TABLE_USERS, " `verify_token` = '".MSV_SQLEscape($_REQUEST["verify_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // remove single use verify token
        API_updateDBItem(TABLE_USERS, "verify_token", "''", " `id` = '".$rowUser["id"]."'");
        // verify email
        API_updateDBItem(TABLE_USERS, "email_verified", "1", " `id` = '".$rowUser["id"]."'");
        //reload user info
        MSV_userLoad($rowUser["id"]);

        // clear msg error message from stack
        // TODO: check if this working
        //$rowMessage =& MSV_get("website.messages");
        //$rowMessage["error"] = array();

        // // $website
        MSV_MessageOK(_t("msg.users.email_verified"));
    }
}

// handle access_token link
// load user session using $_REQUEST["access_token"]
// directly access user account and register session
if (!empty($_REQUEST["access_token"])) {
    $result = API_getDBItem(TABLE_USERS, " `access_token` = '".MSV_SQLEscape($_REQUEST["access_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // load user info, register user session
        MSV_userLoad($rowUser["id"]);

        //  token will never expire
        if (!MSV_HasMessageError()) {
            // TODO: work with token lifetime. it should expire in 24h or ..
            // do expire token
            //API_updateDBItem(TABLE_USERS, "access_token", "''", " `id` = '".$rowUser["id"]."'");
        }
    }
}

// handle reset_token link
// will send email with new password in case of success
if (!empty($_REQUEST["reset_token"])) {
    // try to find user with specified token
    $result = API_getDBItem(TABLE_USERS, " `reset_token` = '".MSV_SQLEscape($_REQUEST["reset_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // make new password
        $rowUser["password"] = MSV_PasswordGenerate();
        if (USER_HASH_PASSWORD) {
            $passwordHash = password_hash($rowUser["password"], PASSWORD_DEFAULT);
        } else {
            $passwordHash = $rowUser["password"];
        }
        // update DB password
        API_updateDBItem(TABLE_USERS, "password", "'".MSV_SQLEscape($passwordHash)."'", " `id` = '".$rowUser["id"]."'");
        // expire reset token
        API_updateDBItem(TABLE_USERS, "reset_token", "''", " `id` = '".$rowUser["id"]."'");

        // send email with new password
        $resultMail = MSV_EmailTemplate("user_password_reset", $rowUser["email"], $rowUser);
        if ($resultMail) {
            MSV_MessageOK(_t("msg.email_sent_to")." <b>".$rowUser["email"]."</b>");
        } else {
            MSV_MessageError(_t("msg.email_sending_error"));
        }
    }
}

// handle SingUp btn
// will redirect to /user/?registered in case of success
// proceed only if registration is allowed
$allowSingUp = MSV_getConfig("users_registration_allow");
if ($allowSingUp && !empty($_REQUEST["doSingUp"])) {
    if (empty($_REQUEST["email"])) {
        MSV_MessageError(_t("msg.users.noemail"));
    }
    if (empty($_REQUEST["password"])) {
        MSV_MessageError(_t("msg.users.nopassword"));
    }
    if (!empty($_REQUEST["password"]) && empty($_REQUEST["password2"])) {
        MSV_MessageError(_t("msg.users.nopassword2"));
    }
    if (!MSV_HasMessageError() && $_REQUEST["password"] !== $_REQUEST["password2"]) {
        MSV_MessageError(_t("msg.users.password_notmatch"));
    }

    if (!MSV_HasMessageError()) {
        // apply site settings
        $doEmailNotify = MSV_getConfig("users_registration_email");
        $doEmailNotifyAdmin = MSV_getConfig("users_registration_email_notify");
        $options = array();
        if ($doEmailNotify) {
            $options[] = "EmailNotifyUser";
        }
        if ($doEmailNotifyAdmin) {
            $options[] = "EmailNotifyAdmin";
        }

        // extract data from request for corresponding table
        $item = MSV_proccessTableData(TABLE_USERS, "");

        // execute request
        $result = MSV_User_Add($item, $options);

        if ($result["ok"]) {
            $userID = $result["insert_id"];
            // load user info and register session
            MSV_userLoad($userID);

            MSV_redirect("/user/?registered");
        } else {
            MSV_MessageError($result["msg"]);
        }
    }

    if (MSV_HasMessageError()) {
        // pass data from request to template to autofill the form
        MSV_assignTableData(TABLE_USERS, "");
    }
}

// handle Login btn
// will redirect in case of success
// 	redirect to _SESSION["redirect_url"] if present
//	redirect to /admin/ if admin is logged
//	redirect to /user/ in other cases
//
// WARNING! When USER_IGNORE_PRIVILEGES is true,
// 			user will be able to login with any password
if (!empty($_REQUEST["doLogin"]) && !empty($_REQUEST["email"]) && !empty($_REQUEST["password"])) {

    $result = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($_REQUEST["email"])."'");
    if ($result["ok"] && !empty($result["data"])) {
        // user access flag
        $login = false;

        // USER_HASH_PASSWORD:true - store password hashed
        if (USER_IGNORE_PRIVILEGES) {
            $login = true;
        }

        if (USER_HASH_PASSWORD) {
            if (password_verify($_REQUEST["password"], $result["data"]["password"])) {
                $login = true;
            }
        } else {
            if ($_REQUEST["password"] === $result["data"]["password"]) {
                $login = true;
            }
        }

        if ($login) {
            // load user info and register session
            MSV_userLoad($result["data"]["id"]);

            $redirect_uri = "/user/";

            if (!empty($_SESSION["redirect_url"])) {
                $redirect_uri = $_SESSION["redirect_url"];
                unset($_SESSION["redirect_url"]);
            }

            if ($result["data"]["access"] === "admin" || $result["data"]["access"] === "superadmin") {
                $redirect_uri = "/admin/";
            }

            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            die;
        }
    }

    MSV_MessageError(_t("msg.users.wrong_password"));
}

// handle Save btn
// will show message in case of success
// if email was changed, verify flag is set to 0
if (!empty($_REQUEST["doSave"])) {
    $userInfo = MSV_get("website.user");

    if (empty($userInfo['id'])) {
        MSV_MessageError(_t("msg.users.noaccess"));
    }

    if (!MSV_HasMessageError()) {
        // set user id
        $_REQUEST["user_id"] = $userInfo['id'];

        // check if email was changed
        if ($_REQUEST["user_email"] !== $userInfo["email"]) {
            $_REQUEST["user_email_verified"] = 0;
        }

        // process update
        $result = MSV_proccessUpdateTable(TABLE_USERS, "user_");
        if ($result["ok"]) {
            MSV_MessageOK(_t("msg.users.saved"));

            //reload user info
            MSV_userLoad($userInfo['id']);
        } else {
            MSV_MessageError($result["msg"]);
        }
    }
}

// handle Password Reset btn
// will show message in case of success
// TODO: apply some checks:
//			- allow password c change once 24h
if (!empty($_REQUEST["doPasswordReset"])) {
    $result = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($_REQUEST["email"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        $reset_token = substr(md5(time()), 0, 10);

        $result = API_updateDBItem(TABLE_USERS, "reset_token", "'".MSV_SQLEscape($reset_token)."'", " `id` = '".$rowUser['id']."'");
        if ($result["ok"]) {
            $rowUser["reset_link"] = HOME_URL."login/?reset_token=".$reset_token;
            $resultMail = MSV_EmailTemplate("user_password_reset_confirm", $rowUser["email"], $rowUser);

            if ($resultMail) {
                MSV_MessageOK(_t("msg.email_sent_to")." <b>".$rowUser["email"]."</b>");
            } else {
                MSV_MessageError(_t("msg.email_sending_error"));
            }
        } else {
            MSV_MessageError(_t("msg.save_error"));
        }
    } else {
        MSV_MessageError(_t("msg.users.email_not_found"));
    }
}

// handle Send Verify btn
// will show message in case of success
// TODO: apply some checks:
//			- apply emails limit
if (isset($_REQUEST["doSendVerify"])) {
    $rowUser = MSV_get("website.user");

    if (!empty($rowUser["id"])) {
        $verify_token = substr(md5(time()), 0, 10);
        $result = API_updateDBItem(TABLE_USERS, "verify_token", "'".MSV_SQLEscape($verify_token)."'", " `id` = '".$rowUser['id']."'");
        if ($result["ok"]) {
            $rowUser["verify_link"] = HOME_URL."settings/?verify_token=".$verify_token;
            $resultMail = MSV_EmailTemplate("user_verify", $rowUser["email"], $rowUser);

            if ($resultMail) {
                MSV_MessageOK(_t("msg.users.verification_sent"));
            } else {
                MSV_MessageError(_t("msg.email_sending_error"));
            }
        } else {
            MSV_MessageError(_t("msg.save_error"));
        }
    } else {
        MSV_MessageError(_t("msg.users.noaccess"));
    }
}

/**
 * Register user session
 * update $_SESSION to save user_id
 * add user row to $website->user
 *
 * @param integer $userID
 * @return null
 */
function MSV_userLoad($userID) {
    $rowUser =& MSV_get("website.user");

    $result = API_getDBItem(TABLE_USERS, " `id` = '".(int)$userID."' and `access` != 'closed'");
    if (!$result["ok"]) {
        MSV_MessageError($result["msg"]);
    } else {
        // TODO: why this is needed?
        $rowUser["user_id"] = (int)$userID;

        // add info to user row
        $rowUser = array_merge($rowUser, $result["data"]);
    }

    $_SESSION["user_id"] = $userID;
    $_SESSION["user_email"] = $rowUser["email"];
    if (empty($rowUser["email_verified"])) {
        MSV_MessageError(_t("msg.users.verification_needed"));
    }
}