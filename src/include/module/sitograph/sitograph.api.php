<?php

// ******** API procedures **********

function api_request_form() {
    $website = msv_get("website");

    $templatePath = ABS_TEMPLATE."/default/sitograph/form-inline.tpl";

    $website->initTemplateEngine();
    $output = $website->templateEngine->fetch($templatePath);

    echo ($output);
}


// ******** filters **********


function AdminLoadUI($admin) {
    msv_include_jsfile(CONTENT_URL."/js/sitograph.js");
    msv_include_cssfile(CONTENT_URL."/css/sitograph.css");
}


function SitographLoadModules($module) {
    $list = msv_list_modules();
    msv_assign_data("modules_list", $list);

    $list = msv_get("website.modules");
    msv_assign_data("modules_installed_list", $list);
    $list = msv_get("website.modulesActive");
    msv_assign_data("modules_active_list", $list);
    
    $urlInfo = parse_url(REP);
    msv_assign_data("rep_url", $urlInfo["scheme"]."://".$urlInfo["host"]);

    $headers = get_headers(REP);
    if(strpos($headers[0],'200')===false) {
        msv_assign_data("rep_status", "offline");
    } else {
        msv_assign_data("rep_status", "online");
    }
}