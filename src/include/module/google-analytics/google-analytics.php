<?php

// embed Google Analytics Code to all webpage
$code = MSV_getConfig("google_analytics_tracking_id");
if ($code) {
	$includeCode = "
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ";
	$includeCode .= "ga('create', '$code', 'auto');\n";
	$rowUser = MSV_get("website.user");
	if (empty($rowUser["user_id"])) {
		$includeCode .= "ga('set', 'userId', ".$rowUser["user_id"].");\n";
	}
	$includeCode .= "ga('send', 'pageview');\n";
	
	MSV_IncludeJS($includeCode);
} 


// Google Service Account auth for server-server usage
$googleservice_auth_json = MSV_getConfig("google_service_auth_json");
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
		MSV_assignData("GA_access_token", $token);
	} else {
		MSV_MessageError("Invalid Google Service Auth JSON file");
	}
}



function Install_GoogleAnalytics($module) {
	
	// 
	// install function
	// run when module in installed
	
	// Google Analytics options
	MSV_setConfig("google_analytics_tracking_id", "xxxxxxx", true, "*");
	MSV_setConfig("google_service_auth_json", "", true, "*");
	
}