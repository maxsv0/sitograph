<?php


MSV_assignData("website_content_manager", '<iframe src="/filemanager/dialog.php?type=0&fldr=/content/" width="100%" height="500" frameborder="0"></iframe>');

$service_folder_id = MSV_getConfig("service_folder_id");
if (!empty($service_folder_id)) {
	MSV_assignData("service_folder_manager", '<iframe src="https://drive.google.com/embeddedfolderview?id='.$service_folder_id.'#grid" style="width:100%; height:300px; border:0;"></iframe>');
	MSV_assignData("service_folder_link", 'https://drive.google.com/drive/folders/'.$service_folder_id.'');
}