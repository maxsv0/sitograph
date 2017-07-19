<?php


msv_assign_data("website_content_manager", '<iframe src="/filemanager/dialog.php?type=0&fldr=/content/" width="100%" height="500" frameborder="0"></iframe>');

$service_folder_id = msv_get_config("service_folder_id");
if (!empty($service_folder_id)) {
    msv_assign_data("service_folder_manager", '<iframe src="https://drive.google.com/embeddedfolderview?id='.$service_folder_id.'#grid" style="width:100%; height:300px; border:0;"></iframe>');
    msv_assign_data("service_folder_link", 'https://drive.google.com/drive/folders/'.$service_folder_id.'');
}