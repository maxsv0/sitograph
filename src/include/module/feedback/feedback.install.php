<?php

function Install_Feedback($module) {

    $docFeedbackTitle = "We are happy to receive your feedback";
    $docFeedbackText = "<img src='/content/images/contacts.png' class='img-responsive'>";

    // install website page with feedback form
    $itemStructure = array(
        "url" => $module->baseUrl,
        "name" => "Feedback",
        "template" => "custom",
        "page_template" => "main-feedback.tpl",
        "sitemap" => 1,
        "menu" => "",
        "menu_order" => 5,
        "document_title" => $docFeedbackTitle,
        "document_text" => $docFeedbackText,
    );
    MSV_Structure_add($itemStructure, array("lang" => "all"));

    // add Email Templates
    $templateFeedbackNotify = '
You are receiving this email because we received a new feedback request from your account.
<br />
Feedback details:<br />
Email: <strong>{email}</strong><br />
Name: <strong>{name}</strong> <br />
Name Title: <strong>{name_title}</strong> <br />
Date: <strong>{date}</strong> <br />
IP: <strong>{ip}</strong> <br />
Text: <br />
{text}<br />
<br /><br />
If you have any questions, please contact us via e-mail <a href="mailto:{support_email}">{support_email}</a>, or via the <a href="{HOME_URL}contacts/">Contact us form</a>.
';

    // install website page with feedback form
    $itemTemplate = array(
        "name" => "feedback_notify",
        "subject" => "Your support ticket was received",
        "text" => $templateFeedbackNotify,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    $templateFeedbackNotifyAdmin = '
Feedback details:<br />
Email: <strong>{email}</strong><br />
Name: <strong>{name}</strong> <br />
Name Title: <strong>{name_title}</strong> <br />
Date: <strong>{date}</strong> <br />
IP: <strong>{ip}</strong> <br />
Text: <br />
{text}<br />
';
    $itemTemplate = array(
        "name" => "feedback_admin_notify",
        "subject" => "New support ticket was received",
        "text" => $templateFeedbackNotifyAdmin,
    );
    MSV_MailTemplate_add($itemTemplate, array("lang" => "all"));

    // add feedback items
    $item = array(
        "sticked" => 1,
        "email" => "tech@sitograph.com",
        "name" => "Sitograph Dev Team",
        "name_title" => "Lead Architect",
        "text" => "<p>Sitograph was created to help maintain huge Web applications.
From one side with Sitograph it is easy to support and manage website content but from the other hand,
developers have a full set of highly customizable tools for website management and configuration.</p>",
        "pic" => "images/feedback_1.png",
        "stars" => 5,
    );
    $result = Feedback_Add($item);

    $item = array(
        "sticked" => 1,
        "email" => "support@sitograph.com",
        "name" => "Sitograph Support",
        "name_title" => "Release Manager",
        "text" => "<p>Open Source Repository created to support Sitograph CMS makes updating process as easy as possible.
 Just two clicks to add new feature on your website!</p>",
        "pic" => "images/feedback_2.png",
        "stars" => 5,
    );
    $result = Feedback_Add($item);

    $item = array(
        "sticked" => 1,
        "email" => "admin@msvhost.com",
        "name" => "MSVHost",
        "name_title" => "CEO",
        "text" => "<p>Sitograph is the perfectly flexible tool that suits any type of Internet Application. Rich catalog
 of extensions together with automated deployment pipeline makes it the best choice for both developers and business owners.</p>",
        "pic" => "images/feedback_3.png",
        "stars" => 5,
    );
    $result = Feedback_Add($item);
}