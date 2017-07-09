<?php

function apiRequest($module) {
    $apiRequest = $module->website->requestUrlMatch[1];

    foreach ($module->website->api as $apiInfo) {
        if ($apiInfo["name"] === $apiRequest) {
            if (function_exists($apiInfo["action"])) {
                $evalCode = "\$result = ".$apiInfo["action"]."(\$module);";
                eval($evalCode);

                echo $result;
            } else {
                MSV_Error("Function not found: ".$apiInfo["action"]);
            }
        }
    }

    die;
}
