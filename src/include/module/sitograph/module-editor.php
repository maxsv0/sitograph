<?php
$allowed_types = array(
    "xml", "tpl", "txt", "htaccess", "html"
);

if (!empty($_REQUEST["edit_file"])) {
    $filePath = ABS.$_REQUEST["edit_file"];
    msv_assign_data("file_path", $_REQUEST["edit_file"]);

    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

    if (isset($_REQUEST["create_confirm"])) {
        if (in_array($ext, $allowed_types)) {
            touch($filePath);
        } else {
            msv_message_error("Allowed file types are: ".implode(", ", $allowed_types));
        }
    }

    if (is_readable($filePath)) {
        if (in_array($ext, $allowed_types)) {
            $fileCont = file_get_contents($filePath);
            msv_assign_data("file_content", $fileCont);
        } else {
            msv_message_error("Allowed file types are: ".implode(", ", $allowed_types));
            return;
        }

        // exit if no write access
        if (!is_writable($filePath)) {
            msv_message_error("Cant write to file: ".$filePath);
            return;
        }

        // edit requests
        if (!empty($_POST["save"])) {
            file_put_contents($filePath, $_POST["form_file_content"]);
            msv_assign_data("file_edit_mode", true);
            msv_assign_data("file_content", $_POST["form_file_content"]);
        }
    } else {
        msv_message_error("Cant read path: ".$filePath);
    }

} else {
    $di = new RecursiveDirectoryIterator(ABS, RecursiveDirectoryIterator::SKIP_DOTS);
    $it = new RecursiveIteratorIterator($di);

    $fileList = array();
    foreach($it as $file) {
        $file = (string)$file;
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_types)) {
            $file = substr($file, strlen(ABS));
            $fileList[] = $file;
        }
    }

    msv_assign_data("file_list", $fileList);
}

if (isset($_REQUEST["edit_mode"])) {
    msv_assign_data("file_edit_mode", true);
}