<?php

/**
 * Install hook for module msv-core
 * This function is executed upon installation
 *
 * @param object $module Module object
 * @return void
 */
function Install_Core($module) {

    // add site settings
    msv_set_config("include_html_head", "", true, "*", "This HTML code is included to all pages, above <body> tag");
    msv_set_config("theme_css_path", "", true, "*", "Path to a CSS file included globaly");
    msv_set_config("theme_js_path", "", true, "*", "Path to a JS file included globaly");
    msv_set_config("theme_use_bootstrap", 1, true, "*", "Include Bootstrap library globaly, values 0/1");
    msv_set_config("theme_use_jquery", 1, true, "*", "Include jQuery library globaly, values 0/1");
    msv_set_config("edit_mode", 0, true, "*", "Admin 'Edit Mode' defined globaly, values 0/1");

    // add messages to default output
    msv_set_config("message_ok", "", true, "*", "Text for a success message displayed over website	");
    msv_set_config("message_error", "", true, "*", "Text for a error message displayed over website. Enabling error message will prevent all website forms from submitting.");

    // FROM field for all emails send by app
    msv_set_config("email_from", "admin@localhost", true, "*", "Email used in sent-by header");
    msv_set_config("email_fromname", "Website", true, "*", "Name used in sent-by header");

    // email accounts used by app
    msv_set_config("admin_email", "admin@localhost", true, "*", "Public Administrator e-mail");
    msv_set_config("support_email", "admin@localhost", true, "*", "Public Support e-mail");
}