<?php

/**
 * API extension for module msv-core
 * Allows to manage table TABLE_SETTINGS
 * All calls require admin level access

 * Allow URLs like:
 * 		/api/settings/list/
 * 		/api/settings/add/
 * 		/api/settings/edit/
 *
 * @return string JSON encoded string containing API call result
 */
function ajaxSettingsRequest($module) {
    if (!MSV_checkAccessUser("admin")) {
        $resultQuery = array(
            "ok" => false,
            "data" => array(),
            "msg" => "No access",
        );
        return json_encode($resultQuery);
    }

    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_SETTINGS, "", "`id` desc", 999, "");
            break;
        case "add":
            $item = MSV_proccessTableData(TABLE_SETTINGS, "");
            $resultQuery = API_itemAdd(TABLE_SETTINGS, $item);
            break;
        case "edit":
            if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "Wrong Input",
                );
            } else {
                $resultQuery = API_updateDBItem(TABLE_SETTINGS, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
            }
            break;
        default:
            $resultQuery = array(
                "ok" => false,
                "data" => array(),
                "msg" => "Wrong API call",
            );
            break;
    }

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}

/**
 * API extension for module msv-core
 * Allows to manage table TABLE_STRUCTURE
 * All calls require admin level access

 * Allow URLs like:
 * 		/api/structure/list/
 * 		/api/structure/add/
 * 		/api/structure/edit/
 *
 * @return string JSON encoded string containing API call result
 */
function ajaxStructureRequest($module) {
    if (!MSV_checkAccessUser("admin")) {
        $resultQuery = array(
            "ok" => false,
            "data" => array(),
            "msg" => "No access",
        );
        return json_encode($resultQuery);
    }

    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_STRUCTURE, "", "`id` desc", 999, "");
            break;
        case "add":
            $item = MSV_proccessTableData(TABLE_STRUCTURE, "");
            $resultQuery = API_itemAdd(TABLE_STRUCTURE, $item);
            break;
        case "edit":
            if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "Wrong Input",
                );
            } else {
                $resultQuery = API_updateDBItem(TABLE_STRUCTURE, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
            }
            break;
        default:
            $resultQuery = array(
                "ok" => false,
                "data" => array(),
                "msg" => "Wrong API call",
            );
            break;
    }

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}

/**
 * API extension for module msv-core
 * Allows to manage table TABLE_DOCUMENTS
 * All calls require admin level access

 * Allow URLs like:
 * 		/api/document/list/
 * 		/api/document/add/
 * 		/api/document/edit/
 *
 * @return string JSON encoded string containing API call result
 */
function ajaxDocumentRequest($module) {
    if (!MSV_checkAccessUser("admin")) {
        $resultQuery = array(
            "ok" => false,
            "data" => array(),
            "msg" => "No access",
        );
        return json_encode($resultQuery);
    }

    $request = MSV_get('website.requestUrlMatch');
    $apiType = $request[2];

    switch ($apiType) {
        case "list":
            $resultQuery = API_getDBList(TABLE_DOCUMENTS, "", "`id` desc", 999, "");
            break;
        case "add":
            $item = MSV_proccessTableData(TABLE_DOCUMENTS, "");
            $resultQuery = API_itemAdd(TABLE_DOCUMENTS, $item);
            break;
        case "edit":
            if (empty($_REQUEST["updateName"]) || empty($_REQUEST["updateID"]) || !isset($_REQUEST["updateValue"]) ) {
                $resultQuery = array(
                    "ok" => false,
                    "data" => array(),
                    "msg" => "Wrong Input",
                );
            } else {
                $resultQuery = API_updateDBItem(TABLE_DOCUMENTS, $_REQUEST["updateName"], "'".MSV_SQLEscape($_REQUEST["updateValue"])."'", "`id` = ".(int)$_REQUEST["updateID"]);
            }
            break;
        default:
            $resultQuery = array(
                "ok" => false,
                "data" => array(),
                "msg" => "Wrong API call",
            );
            break;
    }

    // do not output sql for security reasons
    unset($resultQuery["sql"]);

    // output result as JSON
    return json_encode($resultQuery);
}

/**
 * API extension for module msv-core to upload file to File Storage
 * Requires admin level access

 * URL: /api/uploadpic/
 *
 * @return string Path of a stored file in case of success, error code otherwise.
 */
function ajaxUploadPicture() {
    if (!MSV_checkAccessUser("admin")) {
        return "No access";
    }

    $allowedTypes = array(
        IMAGETYPE_PNG => "png",
        IMAGETYPE_JPEG => "jpg",
        IMAGETYPE_GIF => "gif"
    );

    if (!empty($_FILES["uploadFile"])) {

        $detectedType = exif_imagetype($_FILES["uploadFile"]['tmp_name']);
        if (array_key_exists($detectedType, $allowedTypes)) {

            $fileType = $allowedTypes[$detectedType];

            $table = $_REQUEST["table"];
            $field = $_REQUEST["field"];
            $itemID = $_REQUEST["itemID"];

            // TODO:
            // check $table and $field (config ..)

            // extract file information
            $file = $_FILES["uploadFile"];
            $fileName = $file["name"];
            if (!empty($itemID)) {
                $fileName = $itemID."-".$fileName;
            }

            // store Picture
            $fileResult = MSV_storePic($file["tmp_name"], $fileType, $fileName, $table, $field);
            if (!is_numeric($fileResult)) {
                echo CONTENT_URL."/".$fileResult;
            } else {
                echo $fileResult;
            }
        } else {
            // error
            // file not allowed
        }
    }
}


// *********** TODO: rework everything below

// TODO: + use languages
function ajax_Get_Translit($module) {
    $res = array();

    $index = '';

    if (!empty($_REQUEST['index'])) {
        $index = $_REQUEST['index'];
    } else {
        if (!empty($_REQUEST['ttable'])) {
            $index = get_table_auto_increment_next_value($_REQUEST['ttable']);
        }
    }
    if (!empty($_REQUEST['code_str'])) {
        $res    = array('success'       => 'ok',
            'code_str'          => translit_encode(str_trunc(((!empty($index)? $index.'-':'').$_REQUEST['code_str']),150)));
    } else {
        $res    = array('success'       => '',
            'code_str'          => '');
    }


    return json_encode($res);
}


function get_table_auto_increment_next_value($table) {
    $sql = "SHOW TABLE STATUS FROM `".DB_NAME."` LIKE '$table'";

    $result = API_SQL($sql);
    $resultRow = MSV_SQLRow($result["data"]);

    return $resultRow['Auto_increment'];
    // return $db;
}


function translit_encode($string) {
    $trans_fwd = array(
        'а'=>'a',
        'б'=>'b',
        'в'=>'v',
        'г'=>'g',
        'д'=>'d',
        'е'=>'e',
        'є'=>'e',
        'ё'=>'e',
        'ж'=>'zh',
        'з'=>'z',
        'и'=>'i',
        'і'=>'i',
        'ї'=>'i',
        'й'=>'y',
        'к'=>'k',
        'л'=>'l',
        'м'=>'m',
        'н'=>'n',
        'о'=>'o',
        'п'=>'p',
        'р'=>'r',
        'с'=>'s',
        'т'=>'t',
        'у'=>'u',
        'ф'=>'f',
        'х'=>'h',
        'ц'=>'c',
        'ч'=>'ch',
        'ш'=>'sh',
        'щ'=>'sch',
        'ъ'=>'',
        'ы'=>'i',
        'ь'=>'',
        'э'=>'e',
        'ю'=>'yu',
        'я'=>'ya',
        ' '=>'-',
        '-'=>'-',
        '0'=>'0',
        '1'=>'1',
        '2'=>'2',
        '3'=>'3',
        '4'=>'4',
        '5'=>'5',
        '6'=>'6',
        '7'=>'7',
        '8'=>'8',
        '9'=>'9',
        '_'=>'-',
        '('=>'',
        ')'=>'',
        'a'=>'a',
        'b'=>'b',
        'c'=>'c',
        'd'=>'d',
        'e'=>'e',
        'f'=>'f',
        'g'=>'g',
        'h'=>'h',
        'i'=>'i',
        'j'=>'j',
        'k'=>'k',
        'l'=>'l',
        'm'=>'m',
        'n'=>'n',
        'o'=>'o',
        'p'=>'p',
        'q'=>'q',
        'r'=>'r',
        's'=>'s',
        't'=>'t',
        'u'=>'u',
        'v'=>'v',
        'w'=>'w',
        'x'=>'x',
        'y'=>'y',
        'z'=>'z'
    );
    $result = '';
    $string = mb_strtolower($string, 'utf-8');
    for ($i = 0; $i < mb_strlen($string, 'utf-8'); $i++) {
        //$letter = mb_strtolower($string[$i], mb_detect_encoding($string));
        $letter = mb_substr($string, $i, 1, 'utf-8');
        if ($trans_fwd[$letter] !== NULL) {
            $result .= $trans_fwd[$letter];
        } else {
            $result .= '';
        }
    }
    return $result;
}


function str_trunc($str, $max_chars = 30) {
    $max_chars_tr = (int)round($max_chars*0.8);
    $sep = array(",", " ", ";", "(", "\\", "/", "-", ".");

    $s = $str;
    if (strlen($s) > $max_chars) {
        foreach ($sep as $v) {
            $a = strpos($s, $v, $max_chars_tr);
            if ($a !== false && $a < $max_chars) {
                return substr($s, 0, $a);
            }
        }
        return substr($s, 0, $max_chars);
    } else {
        return $s;
    }
}
