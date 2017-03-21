<?php
if (!is_writable(UPLOAD_FILES_PATH)) {
	MSV_MessageError("Can't write to ".UPLOAD_FILES_PATH);
}

$media_list = array(
	"images" => array("path"=>"/images", "name"=>"Media library"),
	"users" => array("path"=>"/users", "name"=>"Users Media"),
	"blog" => array("path"=>"/articles", "name"=>"Blog Media"),
	"gallery" => array("path"=>"/gallery_album", "name"=>"Gallery Media"),
	"content" => array("path"=>"", "name"=>"File manager"),
);

if (!empty($_REQUEST["media"]) && array_key_exists($_REQUEST["media"], $media_list)) {
	if (!empty($_REQUEST["mediapath"])) {
		// TODO+++++
		// sanitrize $_REQUERS["path"]
		//$media_dir = base64_decode($_REQUEST["mediapath"]);
		$media_dir = substr($_REQUEST["mediapath"], strlen(CONTENT_URL)-1);
		$media_list[$_REQUEST["media"]]["path"] = $media_dir;
	}
	
	MSV_assignData("admin_media_active", $_REQUEST["media"]);
} else {
	MSV_assignData("admin_media_active", "images");
}


foreach ($media_list as $k => $v) {
	$media_list[$k]["list_files"] = admin_build_media_list($v["path"]);
	$media_list[$k]["url"] = CONTENT_URL.$v["path"];
}

MSV_assignData("admin_media_list", $media_list);


$service_folder_id = MSV_getConfig("service_folder_id");
if (!empty($service_folder_id)) {
	MSV_assignData("service_folder_manager", '<iframe src="https://drive.google.com/embeddedfolderview?id='.$service_folder_id.'#grid" style="width:100%; height:300px; border:0;"></iframe>');
	MSV_assignData("service_folder_link", 'https://drive.google.com/drive/folders/'.$service_folder_id.'');
}



function admin_build_media_list($home_path = "/images") {
	$filesList = array();
	
	$media_dir_default = UPLOAD_FILES_PATH.$home_path;
	$media_dir = $media_dir_default;
	if (!empty($_REQUEST["allpath"])) {
		// TODO+++++
		// sanitrize $_REQUERS["path"]
		$media_dir = base64_decode($_REQUEST["allpath"]);
	}

	if ($media_dir !== $media_dir_default) {
		$filesList[$media_dir] = "..";
	}
	
	$media_url = substr($media_dir, strlen(UPLOAD_FILES_PATH));
	$media_url = substr(CONTENT_URL, 1).$media_url;
	$media_url_asb = HOME_URL.$media_url;

	if (file_exists($media_dir) && $handle = opendir($media_dir)) {
	    while (false !== ($entry = readdir($handle))) {
	    	if (strpos($entry, ".") === 0) {
	    		continue;
	    	}
	    	$filePath = $media_dir."/".$entry;
	    	if (!is_dir($filePath)) {
	    		
	    	}
	    	$info = mime_content_type($filePath);
	    	
	    	$filesList[$filePath] = array(
	    		"name" => $entry,
	    		"path" => $filePath,
	    		"type" => $info,
	    		"url" => "/".$media_url."/".$entry,
	    		"urlabs" => $media_url_asb."/".$entry,
	    		"write" => is_writable($filePath),
	    	);
	    }
		closedir($handle);
	}
	
	return $filesList;
}
