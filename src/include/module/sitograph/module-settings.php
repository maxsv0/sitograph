<?php
if (msv_check_accessuser("superadmin")) {
    $listFilter = "(`group` like '%')";
} else {
    $listFilter = "(`group` like 'theme' or `group` like 'website' or `group` like 'user')";
}

if (!empty($_REQUEST["filter_group"])) {
    $listFilterGroup = $_REQUEST["filter_group"];
} else {
    $listFilterGroup = "website";
}
$listFilter .= " and `group` like '".db_escape($listFilterGroup)."'";
msv_assign_data("list_filter_group", $listFilterGroup);

// load default handler to process common functions
$handlerPath = ABS_MODULE."/sitograph/module-table.php";
if (file_exists($handlerPath)) {
    include($handlerPath);
} else {
    msv_message_error("Module handler file not found <b>$handlerPath</b>");
}

$dataEdit = msv_get_config("admin_edit");
if (!empty($dataEdit)) {
    msv_assign_data("list_filter_group", $dataEdit["group"]);
}
