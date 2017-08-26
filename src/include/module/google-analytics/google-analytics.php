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
	if (empty($rowUser["user_id"])) {
		$includeCode .= "ga('set', 'userId', ".$rowUser["user_id"].");\n";
	}
	$includeCode .= "ga('send', 'pageview');\n";

    msv_include_js($includeCode);
} 


// Google Service Account auth for server-server usage
$googleservice_auth_json = msv_get_config("google_service_auth_json");
if (!empty($googleservice_auth_json)) {
	$clientGA = new Google_Client();
	
	try {
		$credentials = @$clientGA->loadServiceAccountJson($googleservice_auth_json,'https://www.googleapis.com/auth/analytics.readonly');
	} catch (Google_Exception $e) {
		$credentials = false;
	}
	
	if ($credentials) {
		$clientGA->setAssertionCredentials($credentials);
		
		if ($clientGA->getAuth()->isAccessTokenExpired()) {
		    $clientGA->getAuth()->refreshTokenWithAssertion();
		}
		
		$service = new Google_Service_Analytics($clientGA);
		$ar = json_decode($clientGA->getAccessToken());
		$token = $ar->access_token;
        msv_assign_data("GA_access_token", $token);
	} else {
        msv_message_error("Invalid Google Service Auth JSON file");
	}
}



function Install_GoogleAnalytics($module) {
	
	// 
	// install function
	// run when module in installed
	
	// Google Analytics options
    msv_set_config("google_analytics_tracking_id", "", true, "*");
    msv_set_config("google_service_auth_json", "", true, "*");
	
}