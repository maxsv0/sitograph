<?php
// Google Service Account auth for server-server usage
$googleclient_secrets_json = msv_get_config("google_client_secrets_json");
if (!empty($googleclient_secrets_json)) {
	$clientGoogle = new Google_Client();

	try {
		$clientGoogle->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
		$clientGoogle->setAuthConfigFile($googleclient_secrets_json);

		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			$clientGoogle->setAccessToken($_SESSION['access_token']);

			//echo json_encode($clientGoogle);
		} else {
			$clientGoogle->setRedirectUri(HOME_URL);

			if (!isset($_GET['code'])) {
				$auth_url = $clientGoogle->createAuthUrl();
				msv_assign_data("google_user_auth_url", $auth_url);
			} else {
				$clientGoogle->authenticate($_GET['code']);
				$_SESSION['access_token'] = $clientGoogle->getAccessToken();

				$token_data = $clientGoogle->verifyIdToken()->getAttributes();
				$email = $token_data["payload"]["email"];
				$iss = $token_data["payload"]["iss"];
				$email_verified = (boolean)$token_data["payload"]["email_verified"];

				// search email in users
				$result = db_get(TABLE_USERS, " `email` = '".($email)."'");

				if (!empty($result["data"])) {
					$user_id = $result["data"]["id"];
					$user_access = $result["data"]["access"];
				} else {
					$userRow = array(
						"email" => $email,
						"email_verified" => $email_verified,
						"iss" => $iss,
					);

					$result = msv_add_user($userRow, array("EmailNotifyUser", "EmailNotifyAdmin"));
					$user_id = $result["insert_id"];
				}

				$_SESSION["user_id"] = $user_id;
				$_SESSION["user_email"] = $email;

				if (!empty($_SESSION["redirect_url"])) {
					$redirect_uri = $_SESSION["redirect_url"];
					unset($_SESSION["redirect_url"]);
				} else {
					$redirect_uri = "/";
				}

				header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			}
		}
	} catch (Google_Exception $e) {
		msv_message_error(_t("msg.invalid_google_client_secrets_json"));
	}
}

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
}


function Install_GoogleLogin($module) {

	//
	// install function
	// run when module in installed

	// Google Login options
	msv_set_config("google_client_secrets_json", "", true, "*", _t("settings.google_client_secrets_json"), "website");
}