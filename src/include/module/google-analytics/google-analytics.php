<?php

// embed Google Analytics Code to all webpage
$code = msv_get_config("google_analytics_tracking_id");
if ($code) {
	$includeCode = "
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ";
	$includeCode .= "ga('create', '$code', 'auto');\n";
	$rowUser = msv_get("website.user");
	if (!empty($rowUser["id"])) {
		$includeCode .= "ga('set', 'userId', ".$rowUser["id"].");\n";
	}
	$includeCode .= "ga('send', 'pageview');\n";

	msv_include_js($includeCode);
}

$ga_webproperty = msv_get_config("google_analytics_webproperty");
if (!empty($ga_webproperty)) {
	msv_assign_data("GA_webproperty", $ga_webproperty);
}

// Google Service Account auth for server-server usage
$googleservice_auth_json = msv_get_config("google_service_auth_json");
if (!empty($googleservice_auth_json)) {
	$clientGA = new Google_Client();
	try {
		$credentials = $clientGA->loadServiceAccountJson($googleservice_auth_json,'https://www.googleapis.com/auth/analytics.readonly');

		$clientGA->setAssertionCredentials($credentials);

		if ($clientGA->getAuth()->isAccessTokenExpired()) {
			$clientGA->getAuth()->refreshTokenWithAssertion();
		}

		$token = json_decode($clientGA->getAccessToken());
		msv_assign_data("GA_access_token", $token->access_token);
	} catch (Google_Exception $e) {
		msv_message_error(_t("msg.invalid_google_service_auth_file"));
	}
}

function Install_GoogleAnalytics($module) {

	// 
	// install function
	// run when module in installed

	// Google Analytics options
	msv_set_config("google_analytics_tracking_id", "", true, "*", _t("settings.google_analytics_tracking_id"), "system");
	msv_set_config("google_analytics_webproperty", "", true, "*", _t("settings.google_analytics_webproperty"), "system");
	msv_set_config("google_service_auth_json", "", true, "*", _t("settings.google_service_auth_json"), "system");
}