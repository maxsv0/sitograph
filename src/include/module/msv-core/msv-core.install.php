<?php

/**
 * Install hook for module msv-core
 * This function is executed upon installation
 *
 * @param object $module Module object
 * @return void
 */
function CoreInstall($module) {

    // add site settings
    MSV_setConfig("include_html_head", "", true, "*", "This HTML code is included to all pages, above <body> tag");
    MSV_setConfig("theme_css_path", "", true, "*", "Path to a CSS file included globaly");
    MSV_setConfig("theme_js_path", "", true, "*", "Path to a JS file included globaly");
    MSV_setConfig("theme_use_bootstrap", 0, true, "*", "Include Bootstrap library globaly, values 0/1");
    MSV_setConfig("theme_use_jquery", 0, true, "*", "Include jQuery library globaly, values 0/1");
    MSV_setConfig("edit_mode", 0, true, "*", "Admin 'Edit Mode' defined globaly, values 0/1");

    // add messages to default output
    MSV_setConfig("message_ok", "", true, "*", "Text for a success message displayed over website	");
    MSV_setConfig("message_error", "", true, "*", "Text for a error message displayed over website");

    // FROM field for all emails send by app
    MSV_setConfig("email_from", "admin@localhost", true, "*", "Email used in sent-by header");
    MSV_setConfig("email_fromname", "Website", true, "*", "Name used in sent-by header");

    // email accounts used by app
    MSV_setConfig("admin_email", "admin@localhost", true, "*", "Public Administrator e-mail");
    MSV_setConfig("support_email", "admin@localhost", true, "*", "Public Support e-mail");
}