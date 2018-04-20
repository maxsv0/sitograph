<?php

/**
 * Filter to enable website API
 * Allow URLs like:
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

    foreach ($module->website->api as $apiInfo) {
        if ($apiInfo["name"] === $apiRequest) {
            if (function_exists($apiInfo["action"])) {
                $moduleObj = msv_get("website.".$apiInfo["module"]);

                // run pre hook
                $hookFn = $apiInfo["action"]."_pre";
                if (function_exists($hookFn)) {
                    $evalCode = "\$result = ".$hookFn."(\$moduleObj);";
                    eval($evalCode);
                }

                // run API function
                $evalCode = "\$result = ".$apiInfo["action"]."(\$moduleObj);";
                eval($evalCode);

                // run post hook
                $hookFn = $apiInfo["action"]."_post";
                if (function_exists($hookFn)) {
                    $evalCode = "\$result = ".$hookFn."(\$moduleObj, \$result);";
                    eval($evalCode);
                }

                // output result
				$module->website->outputData = $result;
            } else {
                msv_error("Function not found: ".$apiInfo["action"]);
            }
        }
    }
}
