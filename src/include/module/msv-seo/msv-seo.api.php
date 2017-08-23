<?php

/**
 * API extension for module msv-seo
 * Allows to manage table TABLE_LEADS
 * All calls require admin level access

 * Allow URLs like:
 *              /api/lead/loadua/123/
 *              /api/lead/loadip/123/
 *              /api/lead/edit/123/
 *
 * @return string JSON encoded string containing API call result
 */
function api_request_lead($module) {
    if (!msv_check_accessuser("admin")) {
        $resultQuery = array(
            "ok" => false,
            "data" => array(),
            "msg" => "No access",
        );
        return json_encode($resultQuery);
    }

    $request = msv_get('website.requestUrlMatch');
    $apiType = $request[2];
	$itemID = (int)$request[3];
	
    if (empty($itemID)) {
        $resultQuery = array(
            "ok" => false,
            "data" => array(),
            "msg" => "No item selected",
        );
        return json_encode($resultQuery);
    }
	

    switch ($apiType) {
        case "loadua":
			$resultQuery = db_get(TABLE_LEADS, "`id` = ".(int)$itemID);
			
			if ($resultQuery["ok"] && !empty($resultQuery["data"])) {
				$lead = $resultQuery["data"];
				$resultQuery["data"] = load_seo_lead_uainfo($lead);
			}

			if (isset($_REQUEST["tohtml"])) {
                $website = msv_get("website");

                $templatePath = ABS_TEMPLATE."/default/sitograph/seo/lead_uainfo.tpl";

                $website->initTemplateEngine();
                $website->templateEngine->assign("info", $resultQuery["data"]["ua_info"]);
                $output = $website->templateEngine->fetch($templatePath);

                return $output;
            }
            break;
        case "loadip":
			$resultQuery = db_get(TABLE_LEADS, "`id` = ".(int)$itemID);
			
			if ($resultQuery["ok"] && !empty($resultQuery["data"])) {
                $lead = $resultQuery["data"];
				$resultQuery["data"] = load_seo_lead_ipinfo($lead);
			}

            if (isset($_REQUEST["tohtml"])) {
                $website = msv_get("website");

                $templatePath = ABS_TEMPLATE."/default/sitograph/seo/lead_ipinfo.tpl";

                $website->initTemplateEngine();
                $website->templateEngine->assign("info", $resultQuery["data"]["ip_info"]);
                $output = $website->templateEngine->fetch($templatePath);

                return $output;
            }
            break;
			
        case "edit":
            if (empty($_REQUEST["updateName"]) || !isset($_REQUEST["updateValue"]) ) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "Wrong Input",
                );
            } else {
                $resultQuery = db_update(TABLE_LEADS, $_REQUEST["updateName"], "'".db_escape($_REQUEST["updateValue"])."'", "`id` = ".$itemID);
            }
            break;
        default:
            $resultQuery = array(
                "ok" => false,
                "data" => array(),
                "msg" => "Wrong API call",
            );
            break;
    }

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}	