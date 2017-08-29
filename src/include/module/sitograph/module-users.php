<?php

// load default handler to process common functions
$handlerPath = ABS_MODULE."/sitograph/module-table.php";
if (file_exists($handlerPath)) {
    include($handlerPath);
} else {
    msv_message_error("Module handler file not found <b>$handlerPath</b>");
}

// USERS custom functions
if (!empty($_REQUEST["reset"])) {
	if (empty($_REQUEST["new_password"])) {
	    msv_message_error("New password can't be empty");
    } else {
        if (USER_HASH_PASSWORD) {
            $passwordHash = password_hash($_REQUEST["new_password"], PASSWORD_DEFAULT);
        } else {
            $passwordHash = $_REQUEST["new_password"];
        }
        // update DB password
        $result = db_update(TABLE_USERS, "password", "'".db_escape($passwordHash)."'", " `id` = '".(int)$_REQUEST["reset"]."'");
        if ($result["ok"]) {
            msv_message_ok(_t("msg.users.password_update_ok"));
        } else {
            msv_message_error($result["msg"]);
        }
    }
}

// reload list
if (!empty($adminList) && is_array($adminList)) {
    $adminListEdited = array();
    foreach ($adminList as $listItemID => $listItem) {

        $result = db_get(TABLE_LEADS, "`user_id` = '".(int)$listItemID."'");
        if ($result["ok"] && !empty($result["data"])) {
            $listItem["status"] = msv_get_leadstatus($result["data"]);
            $listItem["lead"] = $result["data"];
        }

        $result = db_get(TABLE_MAIL_LOG, "`user_id` = '".(int)$listItemID."'");
        if ($result["ok"] && !empty($result["data"])) {
            $listItem["maillog"] = $result["data"];
        }



        $adminListEdited[$listItemID] = $listItem;
    }
    msv_assign_data("admin_list", $adminListEdited);
}
