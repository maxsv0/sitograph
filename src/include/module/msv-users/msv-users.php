<?php
// handle logout link
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
}

// add message to page
if (isset($_REQUEST['registered'])) {
    msv_message_ok(_t("msg.users.reg_success"));
}

// load user info, if session already registered
if (!empty($_SESSION["user_id"])) {
    msv_load_user($_SESSION["user_id"]);
}

// handle email verify link
// load user session using $_REQUEST["verify_token"]
// directly access user account and register session
if (!empty($_REQUEST["verify_token"])) {
    $result = db_get(TABLE_USERS, " `verify_token` = '".db_escape($_REQUEST["verify_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // remove single use verify token
        db_update(TABLE_USERS, "verify_token", "''", " `id` = '".$rowUser["id"]."'");
        // verify email
        db_update(TABLE_USERS, "email_verified", "1", " `id` = '".$rowUser["id"]."'");
        //reload user info
        msv_load_user($rowUser["id"]);

        // clear msg error message from stack
        // TODO: check if this working
        //$rowMessage =& msv_get("website.messages");
        //$rowMessage["error"] = array();

        // // $website
        msv_message_ok(_t("msg.users.email_verified"));
    }
}

// handle access_token link
// load user session using $_REQUEST["access_token"]
// directly access user account and register session
if (!empty($_REQUEST["access_token"])) {
    $result = db_get(TABLE_USERS, " `access_token` = '".db_escape($_REQUEST["access_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // load user info, register user session
        msv_load_user($rowUser["id"], false);

        //  token will never expire
        if (!msv_has_messages()) {
            // TODO: work with token lifetime. it should expire in 24h or ..
            // do expire token
            //db_update(TABLE_USERS, "access_token", "''", " `id` = '".$rowUser["id"]."'");
        }
    }
}

// handle reset_token link
// will send email with new password in case of success
if (!empty($_REQUEST["reset_token"])) {
    // try to find user with specified token
    $result = db_get(TABLE_USERS, " `reset_token` = '".db_escape($_REQUEST["reset_token"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        // make new password
        $rowUser["password"] = msv_generate_password();
        if (USER_HASH_PASSWORD) {
            $passwordHash = password_hash($rowUser["password"], PASSWORD_DEFAULT);
        } else {
            $passwordHash = $rowUser["password"];
        }
        // update DB password
        db_update(TABLE_USERS, "password", "'".db_escape($passwordHash)."'", " `id` = '".$rowUser["id"]."'");
        // expire reset token
        db_update(TABLE_USERS, "reset_token", "''", " `id` = '".$rowUser["id"]."'");

        // send email with new password
        $resultMail = msv_email_template("user_password_reset", $rowUser["email"], $rowUser);
        if ($resultMail) {
            msv_message_ok(_t("msg.email_sent_to")." <b>".$rowUser["email"]."</b>");
        } else {
            msv_message_error(_t("msg.email_sending_error"));
        }
    }
}

// handle SingUp btn
// will redirect to /user/?registered in case of success
// proceed only if registration is allowed
$allowSingUp = msv_get_config("users_registration_allow");
if ($allowSingUp && !empty($_REQUEST["doSingUp"])) {
    if (empty($_REQUEST["email"])) {
        msv_message_error(_t("msg.users.noemail"));
    }
    if (empty($_REQUEST["password"])) {
        msv_message_error(_t("msg.users.nopassword"));
    }
    if (!empty($_REQUEST["password"]) && empty($_REQUEST["password2"])) {
        msv_message_error(_t("msg.users.nopassword2"));
    }
    if (!msv_has_messages() && $_REQUEST["password"] !== $_REQUEST["password2"]) {
        msv_message_error(_t("msg.users.password_notmatch"));
    }

    if (!msv_has_messages()) {
        // apply site settings
        $doEmailNotify = msv_get_config("users_registration_email");
        $doEmailNotifyAdmin = msv_get_config("users_registration_email_notify");
        $options = array();
        if ($doEmailNotify) {
            $options[] = "EmailNotifyUser";
        }
        if ($doEmailNotifyAdmin) {
            $options[] = "EmailNotifyAdmin";
        }

        // extract data from request for corresponding table
        $item = msv_process_tabledata(TABLE_USERS, "");

        // execute request
        $result = msv_add_user($item, $options);

        if ($result["ok"]) {
            $userID = $result["insert_id"];
            // load user info and register session
            msv_load_user($userID);

            msv_redirect("/user/?registered");
        } else {
            msv_message_error($result["msg"]);
        }
    }

    if (msv_has_messages()) {
        // pass data from request to template to autofill the form
        msv_assign_tabledata(TABLE_USERS, "");
    }
}

// handle Login btn
// will redirect in case of success
//      redirect to _SESSION["redirect_url"] if present
//      redirect to /admin/ if admin is logged
//      redirect to /user/ in other cases
//
// WARNING! When USER_IGNORE_PRIVILEGES is true,
//                      user will be able to login with any password
if (!empty($_REQUEST["doLogin"]) && !empty($_REQUEST["email"]) && !empty($_REQUEST["password"])) {

    $result = db_get(TABLE_USERS, " `email` = '".db_escape($_REQUEST["email"])."'");
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
            msv_load_user($result["data"]["id"]);

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

    msv_message_error(_t("msg.users.wrong_password"));
}

// handle Save btn
// will show message in case of success
// if email was changed, verify flag is set to 0
if (!empty($_REQUEST["doSave"])) {
    $userInfo = msv_get("website.user");

    if (empty($userInfo['id'])) {
        msv_message_error(_t("msg.users.noaccess"));
    }

    if (!msv_has_messages()) {
        // set user id
        $_REQUEST["user_id"] = $userInfo['id'];

        // check if email was changed
        if ($_REQUEST["user_email"] !== $userInfo["email"]) {
            $_REQUEST["user_email_verified"] = 0;
        }

        // process update
        $result = msv_process_updatetable(TABLE_USERS, "user_");
        if ($result["ok"]) {
            msv_message_ok(_t("msg.users.saved"));

            //reload user info
            msv_load_user($userInfo['id']);
        } else {
            msv_message_error($result["msg"]);
        }
    }
}

// handle Password Reset btn
// will show message in case of success
// TODO: apply some checks:
//                      - allow password c change once 24h
if (!empty($_REQUEST["doPasswordReset"])) {
    $result = db_get(TABLE_USERS, " `email` = '".db_escape($_REQUEST["email"])."'");
    $rowUser = $result["data"];
    if ($result["ok"] && !empty($rowUser)) {
        $reset_token = substr(md5(time()), 0, 10);

        $result = db_update(TABLE_USERS, "reset_token", "'".db_escape($reset_token)."'", " `id` = '".$rowUser['id']."'");
        if ($result["ok"]) {
            $rowUser["reset_link"] = HOME_URL."login/?reset_token=".$reset_token;
            $resultMail = msv_email_template("user_password_reset_confirm", $rowUser["email"], $rowUser);

            if ($resultMail) {
                msv_message_ok(_t("msg.email_sent_to")." <b>".$rowUser["email"]."</b>");
            } else {
                msv_message_error(_t("msg.email_sending_error"));
            }
        } else {
            msv_message_error(_t("msg.save_error"));
        }
    } else {
        msv_message_error(_t("msg.users.email_not_found"));
    }
}

// handle Send Verify btn
// will show message in case of success
// TODO: apply some checks:
//                      - apply emails limit
if (isset($_REQUEST["doSendVerify"])) {
    $rowUser = msv_get("website.user");

    if (!empty($rowUser["id"])) {
        $verify_token = substr(md5(time()), 0, 10);
        $result = db_update(TABLE_USERS, "verify_token", "'".db_escape($verify_token)."'", " `id` = '".$rowUser['id']."'");
        if ($result["ok"]) {
            $rowUser["verify_link"] = HOME_URL."settings/?verify_token=".$verify_token;
            $resultMail = msv_email_template("user_verify", $rowUser["email"], $rowUser);

            if ($resultMail) {
                msv_message_ok(_t("msg.users.verification_sent"));
            } else {
                msv_message_error(_t("msg.email_sending_error"));
            }
        } else {
            msv_message_error(_t("msg.save_error"));
        }
    } else {
        msv_message_error(_t("msg.users.noaccess"));
    }
}
