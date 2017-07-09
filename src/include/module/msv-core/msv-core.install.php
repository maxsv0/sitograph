<?php

// ********** Install Script ********

/**
 * Install hook for module msv-core
 *
 * @param object $module Module object
 * @return void
 */
function CoreInstall($module) {

    // add site settings
    MSV_setConfig("include_html_head", "", true, "*");
    MSV_setConfig("theme_css_path", "", true, "*");
    MSV_setConfig("theme_js_path", "", true, "*");
    MSV_setConfig("theme_use_bootstrap", 0, true, "*");
    MSV_setConfig("theme_use_jquery", 0, true, "*");
    MSV_setConfig("edit_mode", 0, true, "*");

    // add messages to default output
    MSV_setConfig("message_ok", "", true, "*");
    MSV_setConfig("message_error", "", true, "*");

    // FROM field for all emails send by app
    MSV_setConfig("email_from", "admin@localhost", true, "*");
    MSV_setConfig("email_fromname", "Website", true, "*");

    // email accounts used by app
    MSV_setConfig("admin_email", "admin@localhost", true, "*");
    MSV_setConfig("support_email", "admin@localhost", true, "*");
}