<?php

// ******** API procedures **********

function ajaxFormRequest() {
    $website = MSV_get("website");

    $templatePath = ABS_TEMPLATE."/default/sitograph/form-inline.tpl";

    $website->initTemplateEngine();
    $output = $website->templateEngine->fetch($templatePath);

    echo ($output);
}


// ******** filters **********


function AdminLoadUI($admin) {
    MSV_IncludeJSFile("/content/js/sitograph.js");
    MSV_IncludeCSSFile("/content/css/sitograph.css");
}


function SitographLoadModules($module) {
    $list = MSV_listModules();
    MSV_assignData("modules_list", $list);

    $list = MSV_get("website.modules");
    MSV_assignData("modules_installed_list", $list);
    $list = MSV_get("website.modulesActive");
    MSV_assignData("modules_active_list", $list);
    
    $urlInfo = parse_url(REP);
    MSV_assignData("rep_url", $urlInfo["scheme"]."://".$urlInfo["host"]);

    $headers = get_headers(REP);
    if(strpos($headers[0],'200')===false) {
        MSV_assignData("rep_status", "offline");
    } else {
        MSV_assignData("rep_status", "online");
    }
}