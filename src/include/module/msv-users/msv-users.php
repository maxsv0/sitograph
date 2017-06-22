<?php
/* 
// build in access groups are:
| anonymous
| user
| admin
| website
| root
*/

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

// load user session using $_REQUEST["verify_token"]
// directly access user account and register session
if (!empty($_REQUEST["verify_token"])) {
	$result = API_getDBItem(TABLE_USERS, " `verify_token` = '".MSV_SQLEscape($_REQUEST["verify_token"])."'");
	$rowUser = $result["data"];
	if ($result["ok"] && !empty($rowUser)) {
		// load user info, register user session
		MSV_userLoad($rowUser["id"]);
		
		if (!MSV_HasMessageError()) {
			// remove single use verify token
			API_updateDBItem(TABLE_USERS, "verify_token", "''", " `id` = '".$rowUser["id"]."'");
			// verify email
			API_updateDBItem(TABLE_USERS, "email_verified", "1", " `id` = '".$rowUser["id"]."'");
			//reload user info
			MSV_userLoad($rowUser["id"]);
			
			MSV_MessageOK(_t("msg.users.email_verified"));
		}
	}
}

// load user session using $_REQUEST["access_token"]
// directly access user account and register session
if (!empty($_REQUEST["access_token"])) {
	$result = API_getDBItem(TABLE_USERS, " `access_token` = '".MSV_SQLEscape($_REQUEST["access_token"])."'");
	$rowUser = $result["data"];
	if ($result["ok"] && !empty($rowUser)) {
		// load user info, register user session
		MSV_userLoad($rowUser["id"]);
		
		if (!MSV_HasMessageError()) {
			// access token is for single use
			// TODO: extend token lifetime. it should expire in 24h or .. 
			API_updateDBItem(TABLE_USERS, "access_token", "''", " `id` = '".$rowUser["id"]."'");
		}
	}
}

// handle $_REQUEST["reset_token"]
// send email with new password
if (!empty($_REQUEST["reset_token"])) {
	$result = API_getDBItem(TABLE_USERS, " `reset_token` = '".MSV_SQLEscape($_REQUEST["reset_token"])."'");
	$rowUser = $result["data"];
	if ($result["ok"] && !empty($rowUser)) {
		// new password
		$rowUser["password"] = MSV_PasswordGenerate();
		if (USER_HASH_PASSWORD) {
			$passwordHash = password_hash($rowUser["password"], PASSWORD_DEFAULT);
		}
		// update password
		API_updateDBItem(TABLE_USERS, "password", "'".MSV_SQLEscape($passwordHash)."'", " `id` = '".$rowUser["id"]."'");
		// reset token is for single use
		API_updateDBItem(TABLE_USERS, "reset_token", "''", " `id` = '".$rowUser["id"]."'");
	
		$resultMail = MSV_EmailTemplate("user_password_reset", $rowUser["email"], $rowUser);
		
		if ($resultMail) {
			MSV_MessageOK(_t("msg.email_sent_to")." <b>".$rowUser["email"]."</b>");
		} else {
			MSV_MessageError(_t("msg.email_sending_error"));
		}
	}
}

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
		$result = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($_REQUEST["email"])."'");
		if ($result["ok"] && !empty($result["data"])) {
			MSV_MessageError(_t("msg.users.email_exists"));
		}
	}
	
	if (!MSV_HasMessageError()) {
		$result = UserAdd($_REQUEST["email"], 0, $_REQUEST["password"], $_REQUEST["name"], $_REQUEST["phone"], "user", "regform");
		if ($result["ok"] && !empty($result["insert_id"])) {
			$userID = $result["insert_id"];
			
			// load user info and register session
			MSV_userLoad($userID);
			
            $doEmail = MSV_getConfig("users_registration_email");
            if ($doEmail) {
                $verify_token = substr(md5(time()), 0, 10);
                $verify_link = HOME_URL."settings/?verify_token=".$verify_token;

                $result2 = API_updateDBItem(TABLE_USERS, "verify_token", "'".MSV_SQLEscape($verify_token)."'", " `id` = '".$userID."'");
                if ($result2["ok"]) {
                    $userInfo = array(
                        "email" => $_REQUEST["email"],
                        "password" => $_REQUEST["password"],
                        "name" => $_REQUEST["name"],
                        "phone" => $_REQUEST["phone"],
                        "verify_link" => $verify_link,
                    );
                    MSV_EmailTemplate("user_registration_verify", $_REQUEST["email"], $userInfo);
                }
            }

			header("location: /user/?registered");
			exit;
		}
	}
	
	// pass data to template
	if (!empty($_REQUEST["email"])) {
		MSV_assignData("email", $_REQUEST["email"]);
	}
	if (!empty($_REQUEST["name"])) {
		MSV_assignData("name", $_REQUEST["name"]);
	}
	if (!empty($_REQUEST["phone"])) {
		MSV_assignData("phone", $_REQUEST["phone"]);
	}	
}

if (!empty($_REQUEST["doLogin"]) && !empty($_REQUEST["email"]) && !empty($_REQUEST["password"])) {
	
	$result = API_getDBItem(TABLE_USERS, " `email` = '".MSV_SQLEscape($_REQUEST["email"])."'");
	if ($result["ok"] && !empty($result["data"])) {
		
		// USER_HASH_PASSWORD:true - store password hashed
		$login = false;
		
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
		
		if (!empty($_FILES["user_pic"]) && !empty($_FILES["user_pic"]["name"])) {
			// save user picture
			$fileResult = MSV_storePic($_FILES["user_pic"]["tmp_name"], $_FILES["user_pic"]["type"], "", TABLE_USERS, "pic");
		
			// if result is number - some error occurred
			if (!is_numeric($fileResult)) {
				$_REQUEST["user_pic"] = $fileResult;
			}
		}
		
		// process update
		$result = MSV_proccessUpdateTable(TABLE_USERS, "user_");
		if ($result["ok"]) {
			MSV_MessageOK(_t("msg.users.saved"));
		} else {
			MSV_MessageError($result["msg"]);
		}
		
	}
}

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

if (isset($_REQUEST["doSendVerify"])) {
    $rowUser = MSV_get("website.user");

    if (empty($rowUser['id'])) {
        MSV_MessageError(_t("msg.users.noaccess"));
    }

    if (!MSV_HasMessageError()) {
        $verify_token = substr(md5(time()), 0, 10);
        $result = API_updateDBItem(TABLE_USERS, "verify_token", "'".MSV_SQLEscape($verify_token)."'", " `id` = '".$rowUser['id']."'");
        if ($result["ok"]) {
            $rowUser["verify_link"] = HOME_URL."settings/?verify_token=".$verify_token;
            $resultMail = MSV_EmailTemplate("user_registration_verify", $rowUser["email"], $rowUser);

			if ($resultMail) {
                MSV_MessageOK(_t("msg.users.verification_sent"));
            } else {
                MSV_MessageError(_t("msg.email_sending_error"));
            }
        } else {
            MSV_MessageError(_t("msg.save_error"));
        }
    }
}

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
}

function loadUserSession($module) {
	$rowUser = MSV_get("website.user");

	if (empty($rowUser["user_id"])) {
		$user_auth_url = MSV_getConfig("user_auth_url");
		
		if (empty($user_auth_url)) {
			MSV_setConfig("user_auth_url", "/login/");
		}
	} else {
		MSV_setConfig("user_logout_url", "/?logout");
	}
}

function UserAdd($email, $email_verified = 0, $password = "", $name = "", $phone = "", $access = "user", $iss = "local") {

	// do not allow empty password
	if (empty($password)) {
		$password = MSV_PasswordGenerate();
	}
	
	if (USER_HASH_PASSWORD) {
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	} else {
		$passwordHash = $password;
	}
	
	$verify_token = substr(md5(microtime().rand()), 0, 10);
	$access_token = substr(md5(microtime().rand()), 0, 10);
	
	$item = array(
		"published" => 1,
		"email" => $email,
		"email_verified" => $email_verified,
		"password" => $passwordHash,
		"name" => $name,
		"phone" => $phone,
		"lang_default" => LANG,
		"access" => $access,
		"iss" => $iss,
		"verify_token" => $verify_token,
		"access_token" => $access_token,
	);
	
	$result = API_itemAdd(TABLE_USERS, $item, "*");

	if ($result["ok"]) {
		$doEmail = MSV_getConfig("users_registration_email");
		if ($doEmail) {
			$userInfo = array(
				"email" => $email,
				"password" => $password,
				"name" => $name,
				"phone" => $phone,
				"verify_link" => HOME_URL."settings/?access_token=$access_token",
			);

            if ($email_verified) {
                $resultMail = MSV_EmailTemplate("user_registration", $email, $userInfo);
            } else {
                $resultMail = MSV_EmailTemplate("user_registration_verify", $email, $userInfo);
            }

            if ($resultMail) {
                MSV_MessageOK(_t("msg.email_sent_to")." <b>$email</b>");
            } else {
                MSV_MessageError(_t("msg.email_sending_error"));
            }
		}
	}
	
	return $result;
}

function UsersInstall($module) {
	
	MSV_Structure_add("all", "/user/", _t("structure.users.account"), "custom", "user.tpl", 1, "user", 1, "user");
	MSV_Structure_add("all", "/signup/", _t("structure.users.signup"), "custom", "user-signup.tpl", 1, "nouser", 1, "everyone", "/user/");
	MSV_Structure_add("all", "/login/", _t("structure.users.login"), "custom", "user-login.tpl", 1, "nouser", 2, "everyone", "/user/");
	MSV_Structure_add("all", "/password-reset/", _t("structure.users.password_reset"), "custom", "user-password-reset.tpl", 1, "", 0, "everyone", "/user/");
	MSV_Structure_add("all", "/settings/", _t("structure.users.settings"), "custom", "user-settings.tpl", 1, "user", 2, "user", "/user/");
	
	$item = array(
		"published" => 1,
		"url" => "/?logout",
		"name" => "Logout",
		"menu_id" => "user",
		"order_id" => 100,
	);
	API_itemAdd(TABLE_MENU, $item, "all");
	
	// trigger email sending on user registration
	// default value: 1 => each user will receive email on registration
	MSV_setConfig("users_registration_email", 1, true, "*");
	
	// allow user registration on website using form
	// default value: 0 => users can't register himself
	MSV_setConfig("users_registration_allow", 0, true, "*");

	// install emails
    $header = "";
    $templateRegister = '
Thank you for signing up to <strong>{HOST}</strong>. 
<br />
Use your account data to <a href="{HOME_URL}login/">sign in</a>:<br /><br />
Login: <strong>{email}</strong><br /> 
Password: <strong>{password}</strong> <br /> 
<br /><br /> 
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    $templateRegisterConfirm = '
Thank you for signing up to <strong>{HOST}</strong>. <br />
To complete and confirm your registration, you’ll need to verify your email address. To do so, please click the link below:
<br /><br />
<center>   
<a href="{verify_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Verify Email
</a>
</center>
<br /><br />
Use your account data to <a href="{HOME_URL}login/">sign in</a>:<br /><br />
Login: <strong>{email}</strong><br /> 
Password: <strong>{password}</strong> <br /> 
<br /><br /> 
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
<br /><br /> 
<hr>
If you’re having trouble clicking the "Verify Email" button, copy and paste the URL below into your web browser: <br /> 
<a href="{verify_link}">{verify_link}</a>
';

    $templatePasswordResetConfirm = '
You are receiving this email because we received a password reset request for your account.
<br /><br />
<center>   
<a href="{reset_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Reset Password
</a>
</center>
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
<br /><br /> 
<hr>
If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <br /> 
<a href="{reset_link}">{reset_link}</a>
';
    $templatePasswordReset = '
You successfully reset your password. 
<br />
Login: <strong>{email}</strong><br /> 
Password: <strong>{password}</strong> <br /> 
<br /><br /> 
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    $templateVerify = '
To complete and confirm your registration, you’ll need to verify your email address. To do so, please click the link below:
<br /><br />
<center>   
<a href="{verify_link}" style="display: block; display: inline-block; width: 200px; min-height: 20px;  padding: 10px; background-color: #bb233a; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none;">
Verify Email
</a>
</center>
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{SUPPORT_EMAIL}">{SUPPORT_EMAIL}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    MSV_MailTemplate_add("user_registration", "Welcome to ".HOST, $templateRegister, $header, "all");
    MSV_MailTemplate_add("user_registration_verify", "Welcome to ".HOST, $templateRegisterConfirm, $header, "all");
    MSV_MailTemplate_add("user_verify", "Verify Email", $templateVerify, $header, "all");
    MSV_MailTemplate_add("user_password_reset", "New Password", $templatePasswordReset, $header, "all");
    MSV_MailTemplate_add("user_password_reset_confirm", "Reset Password", $templatePasswordResetConfirm, $header, "all");
}