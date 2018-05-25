<?php

msv_include_jsfile(CONTENT_URL."/js/jstree.min.js");
msv_include_jsfile(CONTENT_URL."/js/comments_admin_function.js");
msv_include_cssfile(CONTENT_URL."/css/jstreestyle.css");


if (empty($section)) {
	return false;
}

$table ='comments';

$tableInfo = msv_get_config_table($table);

msv_assign_data("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	$result = msv_process_updatetable($table, "form_");
	if ($result["ok"]) {

	} else {
        msv_redirect(ADMIN_URL."?section=$section&table=$admin_table&save_error=".$result["msg"]);
	}
}
if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["form_id"];
}
if (!empty($_REQUEST["edit"])) {
	$resultQueryItem = db_get($table, "`id` = '".(int)$_REQUEST["edit"]."'");
	if ($resultQueryItem["ok"]) {

		// make item Url
		$itemUrl = $sectionObj->baseUrl.$resultQueryItem["data"]["url"];

        msv_assign_data("admin_edit", $resultQueryItem["data"]);
	}
}

if (!empty($_REQUEST["delete"])) {
	$resultQueryDelete = db_delete($table, "`id` = '".(int)$_REQUEST["delete"]."'");
    msv_message_ok(_t("msg.deleted_ok"));
}

if (isset($_REQUEST["add_new"])) {
    $commentsQuery = db_get('users', " `id` = '".$_SESSION["user_id"]."' ");
	$item = array(
		"id" => "",
		"published" => 1,
		"deleted" => 0,
		"lang" => LANG,
		"parent_id" => $_REQUEST["parent_id"],
		"expert_id" => $_SESSION["user_id"],
		"base_url" => $_REQUEST["base_url"],
		"section" => $_REQUEST["comment_section"],
		"user_name" => $commentsQuery['data']['name'],
	);
	if (!empty($_REQUEST["edit_key"])) {
		// toDO: ket from table config
		//$item["id"] = $_REQUEST["edit_key"];
	}
    msv_assign_data("admin_edit", $item);
}


