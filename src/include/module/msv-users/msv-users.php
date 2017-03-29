<?php

// access groups:

// anonymous
// user
// admin
// website
// root

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['user_email']);
}


if (!empty($_REQUEST["doSingUp"])) {
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
			
			$_SESSION['user_id'] = $result["insert_id"];
			$_SESSION['user_email'] = $_REQUEST["email"];
			
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
			
			$_SESSION["user_id"] = $result["data"]["id"];
			$_SESSION["user_email"] = $result["data"]["email"];
			
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

	if (!MSV_HasMessageError()) {
		// set user id
		$_REQUEST["user_id"] = $_SESSION['user_id'];
		
		// check if email was changed
		if ($_REQUEST["user_email"] !== $_SESSION['user_email']) {
			$_REQUEST["user_email_verified"] = 0;
			$_SESSION['user_email'] = $_REQUEST["user_email"];
		}
		
		if (!empty($_FILES["user_pic"]) && !empty($_FILES["user_pic"]["name"])) {
			$_REQUEST["user_pic"] = MSV_storePic($_FILES["user_pic"]["tmp_name"], $_FILES["user_pic"]["type"], "", TABLE_USERS, "pic");
		}
		
		// proccess update
		$result = MSV_proccessUpdateTable(TABLE_USERS, "user_");
		if ($result["ok"]) {
			MSV_MessageOK(_t("msg.users.saved"));
		} else {
			MSV_MessageError($result["msg"]);
		}
		
	}
}
if (isset($_REQUEST["doVerify"])) {
	
	$verify_token = substr(md5(time()), 0, 10);
	$access_token = substr(md5(time()), 0, 10);
	$result = API_updateDBItem(TABLE_USERS, "verify_token", "'".MSV_SQLEscape($verify_token)."'", " `id` = '".$_SESSION['user_id']."'");
	if ($result["ok"]) {
			
		$userinfo = MSV_get("website.user");
		
		if ($userinfo["email_verified"]) {
			$verify_link = HOME_URL."settings/?access_token=$access_token";
			$user_verify = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"5\" bgcolor=\"#3092da\" style=\"background-color:#3092da; border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px; font-size:10.5pt; line-height:140%;  font-family: Arial, sans-serif;\">
<tr><td><div style=\"text-align:center; display: inline-block;\">
<a href=\"".$verify_link."\" style=\"text-decoration:none;color:#ffffff;\">"._t("users.goto_account")."</a>
</div></td> </tr>
</table>
";
		} else {
			$verify_link = HOME_URL."settings/?verify_token=".$verify_token."&access_token=$access_token";
			$user_verify = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"5\" bgcolor=\"#3092da\" style=\"background-color:#3092da; border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px; font-size:10.5pt; line-height:140%;  font-family: Arial, sans-serif;\">
<tr><td><div style=\"text-align:center; display: inline-block;\">
<a href=\"".$verify_link."\" style=\"text-decoration:none;color:#ffffff;\">"._t("users.activate_account")."</a>
</div></td> </tr>
</table>
";
		}
		$userinfo["verify_code"] = $user_verify;
		
		
		MSV_EmailTemplate("user_registration", $_SESSION["user_email"], $userinfo);
		
	} else {
		MSV_MessageError(_t("msg.users.error_sending"));
	}
}

	
if (!empty($_SESSION["user_id"])) {
	$rowUser = MSV_get("website.user");
	$rowUser["user_id"] = (int)$_SESSION["user_id"];
	
	if (!empty($rowUser["user_id"])) {
		$result = API_getDBItem(TABLE_USERS, " `id` = '".(int)$rowUser["user_id"]."' ");

		if (!$result["ok"]) {
			MSV_MessageError($result["msg"]);
		} else {
			// add info to user row
			$rowUser = array_merge($rowUser, $result["data"]);
			
			// write changes to website instance
			$this->website->user = $rowUser;
		}
	}
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
		$doEmail = MSV_getConfig("email_registration");
		if ($doEmail) {
			
			$userinfo = array(
				"email" => $email,
				"password" => $password,
				"name" => $name,
				"phone" => $phone,
			);
			
			if ($email_verified) {
				$verify_link = HOME_URL."settings/?access_token=$access_token";
				$user_verify = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"5\" bgcolor=\"#3092da\" style=\"background-color:#3092da; border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px; font-size:10.5pt; line-height:140%;  font-family: Arial, sans-serif;\">
<tr><td><div style=\"text-align:center; display: inline-block;\">
<a href=\"".$verify_link."\" style=\"text-decoration:none;color:#ffffff;\">"._t("users.goto_account")."</a>
</div></td> </tr>
</table>
";
			} else {
				$verify_link = HOME_URL."settings/?verify_token=".$verify_token."&access_token=$access_token";
				$user_verify = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"5\" bgcolor=\"#3092da\" style=\"background-color:#3092da; border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px; font-size:10.5pt; line-height:140%;  font-family: Arial, sans-serif;\">
<tr><td><div style=\"text-align:center; display: inline-block;\">
<a href=\"".$verify_link."\" style=\"text-decoration:none;color:#ffffff;\">"._t("users.activate_account")."</a>
</div></td> </tr>
</table>
";
			}
			$userinfo["verify_code"] = $user_verify;

			MSV_EmailTemplate("user_registration", $email, $userinfo);
		}
	}
	
	return $result;
}

function UsersInstall($module) {
	
	MSV_Structure_add("all", "/user/", _t("structure.users.account"), "default", "user.tpl", 1, "user", 1, "user");
	MSV_Structure_add("all", "/signup/", _t("structure.users.signup"), "default", "user-signup.tpl", 1, "nouser", 1, "everyone", "/user/");
	MSV_Structure_add("all", "/login/", _t("structure.users.login"), "default", "user-login.tpl", 1, "nouser", 2, "everyone", "/user/");
	MSV_Structure_add("all", "/password-reset/", _t("structure.users.password_reset"), "default", "user-password-reset.tpl", 1, "", 0, "everyone", "/user/");
	MSV_Structure_add("all", "/settings/", _t("structure.users.settings"), "default", "user-settings.tpl", 1, "user", 2, "user", "/user/");
	
	$item = array(
		"published" => 1,
		"url" => "/?logout",
		"name" => "Logout",
		"menu_id" => "user",
		"order_id" => 100,
	);
	API_itemAdd(TABLE_MENU, $item, "all");
	
}