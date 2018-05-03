<?php

/**
 * Filter to enable website API
 * Allow URLs like:
 *              /api/
 *              /api/level-1/
 *              /api/level-1/level-2/
 *              /api/level-1/level-2/level-3/
 *
 * Terminates the application
 *
 * @param object $module Current Module object
 * @return null
 */
function api_request($module) {
    $apiRequest = $module->website->requestUrlMatch[1];
    $apiList = msv_get("website.api");
    $apiOutput = "";

    if (empty($apiRequest) && msv_check_accessuser("user")) {
        $result = array(
            "ok" => true,
            "data" => array(),
            "msg" => _t("msg.api.list_of_api"),
        );

        foreach ($apiList as $api) {
            $apiInfo = array(
                "name" => $api["name"],
                "module" => $api["module"],
                "url" => HOME_URL."api/".$api["name"]."/",
            );

            $result["data"][] = $apiInfo;
        }

        $apiOutput  = json_encode($result);
    } else {
        foreach ($apiList as $apiInfo) {
            if ($apiInfo["name"] === $apiRequest) {
                if (function_exists($apiInfo["action"])) {
                    $moduleObj = msv_get("website.".$apiInfo["module"]);

                    // run pre hook
                    $hookFn = $apiInfo["action"]."_pre";
                    if (function_exists($hookFn)) {
                        $evalCode = "\$apiOutput = ".$hookFn."(\$moduleObj);";
                        eval($evalCode);
                    }

                    // run API function
                    $evalCode = "\$apiOutput = ".$apiInfo["action"]."(\$moduleObj);";
                    eval($evalCode);

                    // run post hook
                    $hookFn = $apiInfo["action"]."_post";
                    if (function_exists($hookFn)) {
                        $evalCode = "\$apiOutput = ".$hookFn."(\$moduleObj, \$result);";
                        eval($evalCode);
                    }
                } else {
                    msv_error("Function not found: ".$apiInfo["action"]);
                }
            }
        }
    }

    $module->website->outputData = $apiOutput;
}
