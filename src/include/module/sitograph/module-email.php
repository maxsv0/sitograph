<?php

$emailFrom = msv_get_config("email_from");
$emailFromName = msv_get_config("email_fromname");
if (!empty($emailFromName)) {
    $emailFromHeader = $emailFromName." <".$emailFrom.">";
} else {
    $emailFromHeader = $emailFrom;
}
msv_assign_data("email_from", $emailFromHeader);

if (!empty($_REQUEST["send_to"])) {
    msv_assign_data("email_to", $_REQUEST["send_to"]);
}

if (!empty($_REQUEST["email_preview"])) {
    msv_assign_data("email_to", $_REQUEST["email_to"]);
    msv_assign_data("email_subject", $_REQUEST["email_subject"]);
    msv_assign_data("email_body", $_REQUEST["email_body"]);

    msv_assign_data("email_step_preview", 1);
}

if (!empty($_REQUEST["email_send"])) {

    $toList = $_REQUEST["email_to"];
    $result = msv_email($toList, $_REQUEST["email_subject"], $_REQUEST["email_body"]);

    msv_message_ok("Email was sent. Go to <a href='/admin/?section=maillog'>Mail Log</a> to see latest sent emails");
}