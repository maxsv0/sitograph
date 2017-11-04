<?php

// Google Service Account auth for server-server usage
$googleservice_auth_json = msv_get_config("google_service_auth_json");
if (!empty($googleservice_auth_json)) {
    $clientGoogle = new Google_Client();

    try {
        $credentials = @$clientGoogle->loadServiceAccountJson($googleservice_auth_json,'email');
    } catch (Google_Exception $e) {
        $credentials = false;
    }

    if ($credentials) {
        $clientGoogle->setAssertionCredentials($credentials);

        if ($clientGoogle->getAuth()->isAccessTokenExpired()) {
            $clientGoogle->getAuth()->refreshTokenWithAssertion();
        }

        $_SESSION['access_token'] = $clientGoogle->getAccessToken();
        $token_data = $clientGoogle->verifyIdToken()->getAttributes();
        $email = $token_data["payload"]["email"];
        $iss = $token_data["payload"]["iss"];


        //
        // do something
    } else {
        msv_message_error(_t("msg.invalid_google_service_auth_file"));
    }
}

/*
// TODO: remove this section

// add config after registration
// google_autoload_path, google_client_id, google_client_secret
//
$google_autoload_path = MSV_getConfig("google_autoload_path");
if ($google_autoload_path) {
	
	include($google_autoload_path);
	
	$client_id = MSV_getConfig("google_client_id");
	$client_secret = MSV_getConfig("google_client_secret");
	$home_url = MSV_getConfig("home_url");
	
	$client = new Google_Client();
	
	if (!empty($client) && !empty($client_id) && !empty($client_secret)) {
		// set link for other modules
		$this->website->clientGoogle = &$client;
		
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($home_url);
		
		$client->addScope('email');
		
		if (isset($_REQUEST['logout'])) {
			unset($_SESSION['access_token']);
		}
		
		if (isset($_GET['code'])) {
			
			try {
				$client->authenticate($_GET['code']);
			} catch(Exception $e) {
				echo $e->getMessage();
			}
			
			$_SESSION['access_token'] = $client->getAccessToken();
			
			$token_data = $client->verifyIdToken()->getAttributes();
			$email = $token_data["payload"]["email"];
			$iss = $token_data["payload"]["iss"];
			
			// search email in users
			$result = API_getDBItem(TABLE_USERS, " `email` = '".($email)."'");
			
			if (!empty($result["data"])) {
				$user_id = $result["data"]["id"];
				$user_access = $result["data"]["access"];
			} else {
				$result = UserAdd($email, 1, "", "", "", "user", $iss);
				$user_id = $result["insert_id"];
				$user_access = "user";
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
			die();
		}
		
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			
			$client->setAccessToken($_SESSION['access_token']);
			
			MSV_setConfig("user_logout_url", "/?logout");
		} elseif(empty($_SESSION["user_id"])) {
			$authUrl = $client->createAuthUrl();
			MSV_setConfig("google_user_auth_url", $authUrl);
		}
		
		
		if ($client->getAccessToken()) {
			$_SESSION['access_token'] = $client->getAccessToken();
			
			
			try {
				$token_data = $client->verifyIdToken()->getAttributes();
			} catch (Exception $e) {
				return NULL;
			}
			  
			$rowUser = MSV_get("website.user");
			if ($token_data["payload"]["email_verified"]) {
				$rowUser["email"] = $token_data["payload"]["email"];
			}
			$rowUser["iss"] = $token_data["payload"]["iss"];
			
			// write changes to website instance
			$this->website->user = $rowUser;
		}
	}

}




*/