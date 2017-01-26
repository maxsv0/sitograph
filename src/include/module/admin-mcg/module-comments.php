<?php

MSV_IncludeJSFile("/content/js/jstree.min.js");
MSV_IncludeJSFile("/content/js/comments_admin_function.js");
MSV_IncludeCSSFile("/content/css/jstreestyle.css"); 


if (empty($section)) {
	return false;
}

$table ='comments';

$tableInfo = MSV_getTableConfig($table);

MSV_assignData("admin_table_info", $tableInfo);

if (!empty($_POST["save_exit"]) || !empty($_POST["save"])) {
	$result = MSV_proccessUpdateTable($table, "form_");
	if ($result["ok"]) {
		
	} else {
		MSV_redirect("/admin/?section=$section&table=$admin_table&save_error=".$result["msg"]);
	}
}
if (!empty($_POST["save"])) {
	$_REQUEST["edit"] = $_POST["form_id"];
}
if (!empty($_REQUEST["edit"])) {
	$resultQueryItem = API_getDBItem($table, "`id` = '".(int)$_REQUEST["edit"]."'");
	if ($resultQueryItem["ok"]) {
		
		// make item Url
		$itemUrl = $sectionObj->baseUrl.$resultQueryItem["data"]["url"];
		if (FORSE_TRAILING_SLASH) {
			$itemUrl .= "/";
		}

		
		MSV_assignData("admin_edit", $resultQueryItem["data"]);
	}
}

if (!empty($_REQUEST["delete"])) {
	$resultQueryDelete = API_deleteDBItem($table, "`id` = '".(int)$_REQUEST["delete"]."'");
	MSV_MessageOK(_t("msg.deleted_ok"));
}

if (isset($_REQUEST["add_new"])) {
    $commentsQuery = API_getDBItem('users', " `id` = '".$_SESSION["user_id"]."' ");
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
	MSV_assignData("admin_edit", $item);
}


