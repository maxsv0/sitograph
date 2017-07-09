<?php
$allowed_types = array(
    "xml", "tpl", "txt", "htaccess", "html"
);

if (!empty($_REQUEST["edit_file"])) {
    $filePath = ABS.$_REQUEST["edit_file"];
    MSV_assignData("file_path", $_REQUEST["edit_file"]);

    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

    if (isset($_REQUEST["create_confirm"])) {
        if (in_array($ext, $allowed_types)) {
            touch($filePath);
        } else {
            MSV_messageError("Allowed file types are: ".implode(", ", $allowed_types));
        }
    }

    if (is_readable($filePath)) {
        if (in_array($ext, $allowed_types)) {
            $fileCont = file_get_contents($filePath);
            MSV_assignData("file_content", $fileCont);
        } else {
            MSV_messageError("Allowed file types are: ".implode(", ", $allowed_types));
            return;
        }

        // exit if no write access
        if (!is_writable($filePath)) {
            MSV_messageError("Cant write to file: ".$filePath);
            return;
        }

        // edit requests
        if (!empty($_POST["save"])) {
            file_put_contents($filePath, $_POST["form_file_content"]);
            MSV_assignData("file_edit_mode", true);
            MSV_assignData("file_content", $_POST["form_file_content"]);
        }
    } else {
        MSV_messageError("Cant read path: ".$filePath);
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

    MSV_assignData("file_list", $fileList);
}

if (isset($_REQUEST["edit_mode"])) {
    MSV_assignData("file_edit_mode", true);
}