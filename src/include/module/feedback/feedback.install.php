<?php

function Install_Feedback($module) {
    $themeName = msv_get_config("theme_active");
    $docFeedbackTitle = _t("structure.feedback_title");
    $docFeedbackText = "<img src='".CONTENT_URL."/images/contacts.png' class='img-responsive'>";

    // install website page with feedback form
    $itemStructure = array(
        "url" => $module->baseUrl,
        "name" => _t("structure.feedback"),
        "template" => $themeName,
        "page_template" => "main-feedback.tpl",
        "sitemap" => 1,
        "menu" => "bottom",
        "menu_order" => 15,
        "document_title" => $docFeedbackTitle,
        "document_text" => $docFeedbackText,
    );
    msv_add_structure($itemStructure, array("lang" => "all"));

    // add Email Templates
    $itemTemplate = array(
        "name" => "feedback_notify",
        "subject" => _t("email.feedback_notify"),
        "text" => msv_load_module_doc($module->pathModule, "email-notify"),
    );
    msv_add_mailtemplate($itemTemplate, array("lang" => "all"));

    $itemTemplate = array(
        "name" => "feedback_admin_notify",
        "subject" => _t("email.feedback_admin_notify"),
        "text" => msv_load_module_doc($module->pathModule, "email-admin-notify"),
    );
    msv_add_mailtemplate($itemTemplate, array("lang" => "all"));

    // add feedback items
    $item = array(
        "sticked" => 1,
        "email" => "tech@sitograph.com",
        "name" => "Sitograph Dev Team",
        "name_title" => "Lead Architect",
        "text" => msv_load_module_doc($module->pathModule, "feedback-1"),
        "pic" => "images/feedback/feedback_1.jpg",
        "stars" => 5,
    );
    $result = msv_add_feedback($item);

    $item = array(
        "sticked" => 1,
        "email" => "support@sitograph.com",
        "name" => "Sitograph Support",
        "name_title" => "Release Manager",
        "text" => msv_load_module_doc($module->pathModule, "feedback-2"),
        "pic" => "images/feedback/feedback_2.jpg",
        "stars" => 5,
    );
    $result = msv_add_feedback($item);

    $item = array(
        "sticked" => 1,
        "email" => "admin@msvhost.com",
        "name" => "MSVHost",
        "name_title" => "CEO",
        "text" => msv_load_module_doc($module->pathModule, "feedback-3"),
        "pic" => "images/feedback/feedback_3.jpg",
        "stars" => 5,
    );
    $result = msv_add_feedback($item);
}