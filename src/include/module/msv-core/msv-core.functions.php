<?php

/**
 * Add CSS or JS file directly to website output
 * File is only added if msv_check_include($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include($filePath, $url = '', $access = 'everyone') {
    if (!msv_check_include($url, $access)) {
        return false;
    }

    // detect if $filePath is remote or local file
    // and determine file extension
    if (strpos($filePath, "http") === 0) {
        $type = substr(strrchr($filePath, "."), 1);
    } else {
        $type = pathinfo($filePath, PATHINFO_EXTENSION);
    }

    switch ($type) {
        case "css":
            msv_include_cssfile($filePath, $url, $access);
            break;

        case "js":
            msv_include_jsfile($filePath, $url, $access);
            break;

        default:
            return false;
    }

    return true;
}

/**
 * Add CSS file directly to website output
 * File is only added if msv_check_include($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include_cssfile($filePath, $url = '', $access = 'everyone') {
    $website =& msv_get("website");

    //TODO check $filePath if correct path/url

    if (!msv_check_include($url, $access)) {
        return false;
    }

    if (!in_array($filePath, $website->includeCSS)) {
        $website->includeCSS[] = $filePath;
    }

    return true;
}

/**
 * Add JS file directly to website output
 * File is only added if msv_check_include($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include_jsfile($filePath, $url = '', $access = 'everyone') {
    $website =& msv_get("website");

    //TODO check $filePath if correct path/url

    if (!msv_check_include($url, $access)) {
        return false;
    }

    if (!in_array($filePath, $website->includeCSS)) {
        $website->includeJS[] = $filePath;
    }

    return true;
}

/**
 * Check whether code/file should be included or not.
 * Returns true or false
 *
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_check_include($url = '', $access = 'everyone') {
    $website =& msv_get("website");

    if (!empty($url)) {
        if (strpos($website->requestUrl, $url) !== 0) {
            return false;
        }
    }

    if (!$website->checkAccess($access, $website->user["access"])) {
        return false;
    }

    return true;
}

/**
 * Add CSS code directly to website output
 * code is only added if msv_check_include($url, $access) is passed
 *
 * @param string $cssCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include_css($cssCode, $url = '', $access = 'everyone') {
    $website =& msv_get("website");

    if (!msv_check_include($url, $access)) {
        return false;
    }

    $website->includeCSSCode .= "\n".$cssCode;

    return true;
}

/**
 * Add JS code directly to website output
 * code is only added if msv_check_include($url, $access) is passed
 *
 * @param string $jsCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include_js($jsCode, $url = '', $access = 'everyone') {
    $website =& msv_get("website");

    if (!msv_check_include($url, $access)) {
        return false;
    }

    $website->includeJSCode .= "\n".$jsCode;

    return true;
}

/**
 * Add HTML code directly to website output
 * code is only added if msv_check_include($url, $access) is passed
 *
 * @param string $htmlCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function msv_include_html($htmlCode, $url = '', $access = 'everyone') {
    $website =& msv_get("website");

    if (!msv_check_include($url, $access)) {
        return false;
    }

    $website->includeHTMLCode .= "\n".$htmlCode;

    return true;
}

function msv_log($logText = "", $type = "warning") {
    $website =& msv_get("website");

    $website->log($logText, $type);

    return true;
}

/**
 * Adds 'success' message to website output
 *
 * @param string $messageText Optional Text of a message
 * @return boolean
 */
function msv_message_ok($messageText = "") {
    if (empty($messageText)) return false;

    $website =& msv_get("website");
    $website->messages["success"][] = $messageText;

    return true;
}

/**
 * Adds 'error' message to website output
 *
 * @param string $messageText Optional Text of a message
 * @return boolean
 */
function msv_message_error($messageText = "") {
    if (empty($messageText)) return false;

    $website =& msv_get("website");
    $website->messages["error"][] = $messageText;

    return true;
}

/**
 * Returns true if website has any messages of given type.
 *
 * @param string $type Optional Type of message defaults to "error"
 * @return boolean
 */
function msv_has_messages($type = "error") {
    $website = msv_get("website");

    if (!empty($website->messages[$type])) {
        return true;
    }

    return false;
}

/**
 * Stop website execution and output error page with message $errorText
 *
 * @param string $errorText Optional Text of a message
 * @return boolean
 */
function msv_error($errorText = "") {
    $website = msv_get("website");

    //TODO: make log

    $website->outputError($errorText);
    return true;
}

/**
 * Add element to Navigation array
 * In case if $url is empty span text will be rendered instead of a link
 *
 * @param string $name Name of a link
 * @param string $url Optional URL of an link; defaults to ''
 * @param boolean $pos Optional Add new element to the beginning of an Navigation array; defaults to false
 * @return void
 */
function msv_set_navigation($name, $url = "", $pos = false) {
    $website =& msv_get("website");

    // TODO : CHECK ...

    $ar = array(
        "name" => $name,
        "url" => $url,
    );
    if ($pos) {
        array_unshift($website->navigation, $ar);
    } else {
        $website->navigation[] = $ar;
    }

    return true;
}

function msv_set_config($param, $value, $updateDB = false, $lang = LANG, $desc = "", $group = "system") {
    $website =& msv_get("website");

    // TODO : CHECK ...
    if (array_key_exists($param, $website->config)) {
        $website->config[$param] = $value;

        if ($updateDB) {
            return db_update(TABLE_SETTINGS, "value", "'".db_escape($value)."'", " `param` = '".$param."'");
        }
    } else {
        $website->config[$param] = $value;

        if ($updateDB) {
            $item = array(
                "published" => 1,
                "value" => $value,
                "param" => $param,
                "description" => $desc,
                "group" => $group
            );

            return db_add(TABLE_SETTINGS, $item, $lang);
        }
    }

    return false;
}

/**
 * Searches for config value with name $param
 *
 * @param string $param Name of the config parameter
 * @return mixed
 */
function msv_get_config($param) {
    $website = msv_get("website");

    // TODO : CHECK ...

    if (array_key_exists($param, $website->config)) {

        return $website->config[$param];

    } else {

        return false;
    }
}

/**
 * Returns an array with table configuration
 *
 * @param string $table Name of the table
 * @return array
 */
function msv_get_config_table($table) {
    //TODO  add some check

    $tablesList = msv_get("website.tables");

    if (!array_key_exists($table, $tablesList)) {
        return false;
    }

    $infoTable = $tablesList[$table];

    return $infoTable;
}

/**
 * Returns a result row as an associative array
 *
 * @param object $sqlQuery mysqli_result
 * @return array
 */
function db_fetch_row($sqlQuery) {

    $row = mysqli_fetch_assoc($sqlQuery);

    return $row;
}

/**
 * Escape SQL code for current DB connection
 *
 * @param string $string SQL code
 * @return string
 */
function db_escape($string) {

    $website = msv_get("website");

    $string = (string)$string;

    $stringEscaped = mysqli_real_escape_string($website->config["db"], $string);

    return $stringEscaped;
}

/**
 * Stores file in filesystem
 *
 * File is loaded from $url, renamed and stored in corresponding folder
 * In case if $table is specified path is: $table/$year/$month/$fileName,
 * otherwise stored to UPLOAD_FILES_PATH/$fileName
 * Returns file path or error code
 * path example: content/table/year/month/hash.jpg
 *
 * @param string $url URL of a file to be stored
 * @param string $type Optional Extension of a file; defaults to 'jpg'
 * @param string $name Optional Name of stored file. Random name will be generated if empty
 * @param string $table Optional Name of table where this file is stored
 * @param string $field Optional Name of field in table where this file is stored
 * @return string|integer
 */
function msv_store_file($url, $type = "jpg", $name = "", $table = "", $field = "") {

    $typeExt = msv_format_mimetype($type);
    if (!empty($typeExt)) {
        $type = $typeExt;
    }

    if (empty($url)) {
        return false;
    }

    $cont = file_get_contents($url);
    if (!$cont) {
        return false;
    }

    $hash = uniqid();

    if (!empty($name)) {
        if (substr($name, -strlen($type)-1) == ".".$type) {
            $name = substr($name, 0, -strlen($type)-1);
        }
        $fileName = $name."-".$hash.".".$type;
    } elseif (!empty($field)) {
        $fileName = $hash."-".$field.".".$type;
    } else {
        $fileName = $hash.".".$type;
    }

    // create folders in path
    if (!empty($table)) {
        $dirPath = UPLOAD_FILES_PATH."/".$table;

        if (!file_exists($dirPath)) {
            $r = mkdir($dirPath);
            if (!$r) {
                return -1;
            }
        }

        $year = date("Y");
        $month = date("m");


        $dirPath = $dirPath."/".$year;
        if (!file_exists($dirPath)) {
            $r = mkdir($dirPath);
            if (!$r) {
                return -2;
            }
        }

        $dirPath = $dirPath."/".$month;
        if (!file_exists($dirPath)) {
            $r = mkdir($dirPath);
            if (!$r) {
                return -3;
            }
        }

        $fileUrl = $table."/".$year."/".$month."/".$fileName;
    } else {
        $dirPath = UPLOAD_FILES_PATH;

        $fileUrl = $fileName;
    }

    $filePath = $dirPath."/".$fileName;

    $r = file_put_contents($filePath, $cont);
    if ($r) {
        return $fileUrl;
    }

    return -10;
}

/**
 * Stores picture in filesystem
 * Picture will be resized according to $table/$field settings
 *
 * Original file is stored using msv_store_file function
 * In case if $table and $field are specified picture will be resized
 * according to max-width/max-height settings for $field in $table
 * Resized file is saved with $type file type
 *
 * @param string $url URL of a file to be stored
 * @param string $type Optional Extension of a picture; defaults to 'jpg'
 * @param string $name Optional Name of stored file. Random name will be generated if empty
 * @param string $table Optional Name of table where this file is stored
 * @param string $field Optional Name of field in table where this file is stored
 * @return string|integer
 */
function msv_store_pic($url, $type = "jpg", $name = "", $table = "", $field = "") {

    $typeExt = msv_format_mimetype($type);
    if (!empty($typeExt)) {
        $type = $typeExt;
    }

    // store original file
    $fileResult = msv_store_file($url, $type, $name, $table, $field);

    if (is_numeric($fileResult)) {
        // result is error
        return $fileResult;
    }

    $fileUrl = $fileResult;
    $filePath = UPLOAD_FILES_PATH."/".$fileResult;

    // if resize is needed
    if (!empty($field) && !empty($table)) {
        // get a file
        $cont = file_get_contents($filePath);
        if (!$cont) {
            return -5;
        }

        // get table info
        $tablesList = msv_get("website.tables");
        $infoTable = $tablesList[$table];

        $infoField = $infoTable["fields"][$field];

        // check img size from config
        if (!empty($infoField["max-width"]) || !empty($infoField["max-height"])) {
            // create imgage using GD
            $img = imagecreatefromstring($cont);

            $height = imagesy($img);
            $width = imagesx($img);

            if (!empty($infoField["max-width"]) && $width > $infoField["max-width"]) {
                $widthNew = $infoField["max-width"];
                $heightNew = $height/$width*$widthNew;

                $imgNew = imagecreatetruecolor($widthNew, $heightNew);

                // save alpha channel
                imagesavealpha($imgNew, true);
                imagealphablending($imgNew, false);

                $bgColor = imagecolorallocatealpha($imgNew, 255, 255, 255, 0);
                imagefill($imgNew, 1, 1, $bgColor);

                // copy image
                imagecopyresampled($imgNew, $img, 0, 0, 0, 0, $widthNew, $heightNew, $width, $height);
                $img = $imgNew;


                switch ($type) {
                    case "png":
                        imagepng($img, $filePath);
                        break;
                    case "gif":
                        imagegif($img, $filePath);
                        break;
                    case "jpg":
                        imagejpeg($img, $filePath, 90);
                        break;
                    default:
                        imagejpeg($img, $filePath, 90);
                        break;
                }

            } else {

                // do not resize
                // do not change original file

            }
        }
    }

    return $fileUrl;
}

/**
 * Returns an child of $website object that corresponds to path in $param
 * path is exploded with '.'
 * usage: msv_get('website.tables'), msv_get('website.api')
 *
 * @param string $param Optional Name/path of the object to be returned; defaults to 'website'
 * @return mixed
 */
function &msv_get($param = "website") {

    global $website;
    if (empty($website)) {
        // TODO: ???
        die("MSV instance not found");
    }

    $returnObj =& $website;

    $arPath = explode(".", $param);
    if (count($arPath) > 1) {
        for ($i = 1; $i < count($arPath); $i++) {
            $item = $arPath[$i];
            $returnObj =& $returnObj->{$item};
        }
    }

    return $returnObj;
}

function msv_check_files() {
    $website = msv_get("website");


    $di = new RecursiveDirectoryIterator(ABS, RecursiveDirectoryIterator::SKIP_DOTS);
    $it = new RecursiveIteratorIterator($di);

    $fileModuleList = array();
    foreach ($website->modules as $module) {
        $files = $website->{$module}->files;

        foreach ($files as $file) {
            $fileModuleList[$file["abs_path"]] = $module;
        }
    }

    $fileList = array();
    foreach($it as $file) {
        $file = (string)$file;
        if (strpos($file, "/include/custom/") !== false) continue;
        if (strpos($file, "/templates/custom/") !== false) continue;
        if (strpos($file, ".git") !== false) continue;
        if (strpos($file, ".DS_Store") !== false) continue;
        $fileList[] = $file;
    }

    $strOut = "";
    foreach ($fileList as $file) {
        $strOut .= "$file ";
        if (array_key_exists($file, $fileModuleList)) {
            $strOut .= "<span style='color:green;'>".$fileModuleList[$file]." - ok</span>";
        } else {
            $strOut .= "<span style='color:red;'>NOT FOUND</span>";
        }
        $strOut .= "<br>";
    }
    return $strOut;
}

/**
 * Assign the data from request to template engine adding name prefix
 *
 * @param string $table
 * @param string $prefix Optional; defaults to ''
 * @return boolean Result of the action
 */
function msv_assign_tabledata($table, $prefix = "") {
    $tableInfo = msv_get_config_table($table);

    if (empty($tableInfo)) {
        return false;
    }

    foreach ($tableInfo["fields"] as $item) {
        if (!array_key_exists($prefix.$item["name"], $_REQUEST)) {
            msv_assign_data($prefix.$item["name"], $_REQUEST[$prefix.$item["name"]]);
        }
    }

    return true;
}

function msv_format_data($table, $dataRow) {
    //TODO ...

    $tablesList = msv_get("website.tables");

    if (!array_key_exists($table, $tablesList)) {
        return $dataRow;
    }

    $infoTable = $tablesList[$table];

    foreach ($infoTable["fields"] as $field) {
        $value = $dataRow[$field["name"]];

        switch ($field["type"]) {
            case "pic":
                if (!empty($value)) {
                    if (strpos($value, "http") !== 0) {
                        $dataRow[$field["name"]] = CONTENT_URL."/".$value;
                    }
                }

                break;
            case "array":
            case "multiselect":
                $dataRow[$field["name"]] = unserialize($value);
                break;
            case "updated":
            case "date":
            case "datetime":
                if (!empty($value) && $value !== "0000-00-00 00:00:00") {
                    $dataRow[$field["name"]] = date(DATE_FORMAT, strtotime($value));
                }
                break;

            default:
                break;
        }
    }


    return $dataRow;
}

function msv_process_tabledata($table, $prefix = "") {
    $tableInfo = msv_get_config_table($table);
    if (empty($tableInfo)) return false;

    // array to be returned
    $dataItem = array();

    foreach ($tableInfo["fields"] as $item) {
        // skip fields that where not changed
        if (!array_key_exists($prefix.$item["name"], $_REQUEST) &&
            !array_key_exists($prefix.$item["name"], $_FILES)) {
            continue;
        }

        $value = $_REQUEST[$prefix.$item["name"]];
        switch ($item["type"]) {
            case "id":
            case "int":
                $dataItem[$item["name"]] = (int)$value;
                break;
            case "float":
                $dataItem[$item["name"]] = (float)$value;
                break;
            case "published":
            case "deleted":
            case "bool":
                if (empty($value)) {
                    $dataItem[$item["name"]] = 0;
                } else {
                    $dataItem[$item["name"]] = 1;
                }
                break;
            case "lang":
                // TODO: check lang
                $dataItem[$item["name"]] = $value;
                break;
            case "author":
                // TODO: check session user access lvl to avoid author field change
                if (empty($value)) {
                    $rowInfo = msv_get("website.user");
                    if (!empty($rowInfo["email"])) {
                        $dataItem[$item["name"]] = $rowInfo["email"];
                    } else {
                        $dataItem[$item["name"]] = "unknown";
                    }
                } else {
                    $dataItem[$item["name"]] = $value;
                }
                break;
            case "pic":
            case "file":
                // if string passed - store it
                // if _FILES entry exists then store file first
                if (array_key_exists($prefix.$item["name"], $_FILES) && !empty($_FILES[$prefix.$item["name"]]["tmp_name"])) {
                    $type = $_FILES[$prefix.$item["name"]]["type"];
                    $path = $_FILES[$prefix.$item["name"]]["tmp_name"];
                    $name = $_FILES[$prefix.$item["name"]]["name"];

                    // store file
                    if ($item["type"] === "pic") {
                        $fileResult = msv_store_pic($path, $type, $name, $table, $item["name"]);
                    } else {
                        $fileResult = msv_store_file($path, $type, $name, $table, $item["name"]);
                    }
                    if (!is_numeric($fileResult)) {
                        $dataItem[$item["name"]] = $fileResult;
                    } else {
                        // error storing file
                        $dataItem[$item["name"]] = "";
                    }
                } elseif (isset($_REQUEST[$prefix.$item["name"]])) {
                    if (strpos($value, CONTENT_URL) === 0) {
                        $value = substr($value, strlen(CONTENT_URL)+1);
                    }
                    $dataItem[$item["name"]] = $value;
                }
                break;
            case "updated":
                // ignore user input, set current time
                $dataItem[$item["name"]] = date("Y-m-d H:i:s");
                break;
            case "array":
            case "multiselect":
                if (is_array($value)) {
                    $dataItem[$item["name"]] = $value;
                } else {
                    $dataItem[$item["name"]] = array();
                }
                break;
            case "date":
            case "datetime":
                if (!empty($value)) {
                    $value = strtotime($value);
                    if ($value > 0) {
                        $dataItem[$item["name"]] = date("Y-m-d H:i:s", $value);
                    } else {
                        $dataItem[$item["name"]] = 'NULL';
                    }
                }
                break;
            case "url":
            case "text":
            case "doc":
            case "str":
                // do nothing, just store value
                $dataItem[$item["name"]] = (string)$value;
                break;
            default:
                msv_message_error("Unknown data type: ".$item["type"]);
                break;
        }
    }

    return $dataItem;
}

function msv_process_updatetable($table, $prefix = "") {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // extract data from request for corresponding table
    $item = msv_process_tabledata($table, $prefix);

    if (empty($item)) {
        $result["msg"] = "Can't validate input data";
        return $result;
    }

    $result = db_update_row($table, $item);
    return $result;
}

/**
 * Format a size in bytes, adding corresponding units of measure
 * Returns formatted string
 *
 * @param integer $size Size in bytes to be formatted
 * @return string Formatted string
 */
function msv_format_size($size) {
    if ($size >= 1073741824) {
        $text = number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        $text = number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        $text = number_format($size / 1024, 2) . ' KB';
    } elseif ($size > 1) {
        $text = $size . ' bytes';
    } elseif ($size == 1) {
        $text = $size . ' byte';
    } else {
        $text = '0 bytes';
    }
    return $text;
}

/**
 * Returns a locale constant for current language
 * PHP constants are converted into values before returning
 *
 * @param string $textID ID of a text constand to be returned
 * @return string
 */
function _t($textID) {
    $website = msv_get("website");

    if (array_key_exists($textID, $website->locales)) {
        $retStr = $website->locales[$textID];

        // replace pattern:
        // {CONSTANT} into values
        //

        $retStr = preg_replace_callback(
            '~\{(\w+?)\}~sU',
            create_function('$t','
                        return constant($t[1]);
                    '),
            $retStr);

        return $retStr;
    } else {
        return $textID;
    }
}

/**
 * Add new structure item
 * Database table: TABLE_STRUCTURE
 * SEO is updated in case of success
 * Document is updated
 * Menu item is updated
 *
 * checks for required fields and correct values
 * $row["url"] is required
 * $row["name"] is required
 * supports lang = "all" for recursive call
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: lang
 * @return array Result of a API call
 */
function msv_add_structure($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["url"])) {
        $result["msg"] = _t("msg.structure.nourl");
        return $result;
    }
    if (empty($row["name"])) {
        $result["msg"] = _t("msg.structure.noname");
        return $result;
    }

    // get lang if present
    if (!empty($options["lang"])) {
        $lang = $options["lang"];
    } else {
        $lang = LANG;
    }

    // run recursively and exit
    if ($lang === "all") {
        $website = msv_get("website");

        $n = 0;
        foreach ($website->languages as $langID) {
            $optionsLang = $options;
            $optionsLang["lang"] = $langID;
            msv_add_structure($row, $optionsLang);
            $n++;
        }

        $result["msg"] = "Recursively called $n times";
        $result["ok"] = true;
        return $result;
    }

    $parent_id = 0;
    if (!empty($row["parent_url"])) {
        $resultParent = db_get(TABLE_STRUCTURE, "`url` = '".db_escape($row["parent_url"])."'", $lang);
        if ($resultParent["ok"] && !empty($resultParent["data"])) {
            $row["parent_id"] = $resultParent["data"]["id"];
        }
    }

    // set defaults
    if (empty($row["parent_id"])) {
        $row["parent_id"] = 0;
    } else {
        $row["parent_id"] = (int)$row["parent_id"];
    }
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }
    if (empty($row["sitemap"])) {
        $row["sitemap"] = 0;
    } else {
        $row["sitemap"] = (int)$row["sitemap"];
    }
    if (empty($row["menu_order"])) {
        $row["menu_order"] = 0;
    } else {
        $row["menu_order"] = (int)$row["menu_order"];
    }
    if (empty($row["menu_parent_id"])) {
        $row["menu_parent_id"] = 0;
    } else {
        $row["menu_parent_id"] = (int)$row["menu_parent_id"];
    }

    // set empty fields
    if (empty($row["template"])) $row["template"] = "";
    if (empty($row["page_template"])) $row["page_template"] = "";
    if (empty($row["access"])) $row["access"] = "everyone";
    if (empty($row["menu"])) $row["menu"] = "";
    if (empty($row["document_title"])) $row["document_title"] = "";
    if (empty($row["document_text"])) $row["document_text"] = "";

    $result = db_add(TABLE_STRUCTURE, $row, $lang);

    if ($result["ok"]) {
        // get net structure id
        $structure_id = $result["insert_id"];

        // add seo
        $itemSEO = array(
            "url" => $row["url"],
            "title" => $row["name"],
            "description" => $row["name"],
            "keywords" => $row["name"],
            "sitemap" => $row["sitemap"],
        );
        msv_add_seo($itemSEO, array("lang" => $lang));

        // add document
        if (!empty($row["document_title"]) || !empty($row["document_text"])) {
            $itemDocument = array(
                "name" => $row["document_title"],
                "text" => $row["document_text"],
            );
            $resultDocument = msv_add_document($itemDocument, array("lang" => $lang));

            // update structure=>set document
            if ($resultDocument["ok"]) {
                db_update(TABLE_STRUCTURE, "page_document_id", $resultDocument["insert_id"], " id = '".$structure_id."'");
            }
        }

        if (!empty($row["menu"])) {
            $item = array(
                "published" => 1,
                "url" => $row["url"],
                "name" => $row["name"],
                "menu_id" => $row["menu"],
                "structure_id" => $structure_id,
                "order_id" => $row["menu_order"],
                "parent_id" => $row["menu_parent_id"],
            );
            db_add(TABLE_MENU, $item, $lang);
        }
    }

    return $result;
}

/**
 * Add new dcument
 * Database table: TABLE_DOCUMENTS
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: lang
 * @return array Result of a API call
 */
function msv_add_document($row, $options = array()) {
    // set defaults
    if (!empty($row["published"])) {
        $row["published"] = (int)$row["published"];
    } else {
        $row["published"] = 1;
    }
    if (!empty($options["lang"])) {
        $lang = $options["lang"];
    } else {
        $lang = LANG;
    }

    // set empty fields
    if (empty($row["name"])) $row["name"] = "";
    if (empty($row["text"])) $row["text"] = "";

    $result = db_add(TABLE_DOCUMENTS, $row, $lang);

    return $result;
}

/**
 * Add new mail template
 * Database table: TABLE_MAIL_TEMPLATES
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: lang
 * @return array Result of a API call
 */
function msv_add_mailtemplate($row, $options = array()) {
    // set defaults
    if (!empty($row["published"])) {
        $row["published"] = (int)$row["published"];
    } else {
        $row["published"] = 1;
    }
    if (!empty($options["lang"])) {
        $lang = $options["lang"];
    } else {
        $lang = LANG;
    }

    // set empty fields
    if (empty($row["name"])) $row["name"] = "";
    if (empty($row["text"])) $row["text"] = "";
    if (empty($row["subject"])) $row["subject"] = "";
    if (empty($row["header"])) $row["header"] = "";

    $result = db_add(TABLE_MAIL_TEMPLATES, $row, $lang);

    return $result;
}

/**
 * Send an email using mail() function
 * msv_get_config("email_from") and msv_get_config("email_fromname") is used in FROM field
 * Additional header is added with $header
 * Content-type is set to text/html
 *
 * @param string $to Send to this email
 * @param string $subject Subject of an email
 * @param string $body Optional Email body can be HTML or plain text
 * @param string $header Optional Additional header
 * @return boolean
 */
function msv_email_default($to = "", $subject = "", $body = "", $header = "") {

    $emailFrom = msv_get_config("email_from");
    $emailFromName = msv_get_config("email_fromname");
    if (!empty($emailFromName)) {
        $emailFromHeader = $emailFromName." <".$emailFrom.">";
    } else {
        $emailFromHeader = $emailFrom;
    }
    $headers = "From: ".$emailFromHeader."\r\nContent-type: text/html; charset=\"UTF-8\" \r\n";
    if (!empty($header)) {
        $headers .= $header;
    }

    return mail($to, $subject, $body, $headers);
}

/**
 * Send an email using current email provider.
 * msv_get_config("email_from") and msv_get_config("email_fromname") is used in FROM field
 * Additional header is added with $header
 *
 * @param string $to Send to this email
 * @param string $subject Subject of an email
 * @param string $body Optional Email body can be HTML or plain text
 * @param string $header Optional Additional header
 * @return boolean
 */
function msv_email($to = "", $subject = "", $body = "", $header = "") {
    // get Mailer function
    $mailer = msv_get_config("mailer");

    $result = call_user_func_array($mailer, array($to, $subject, $body, $header));

    if (!$result) {
        $resultStr = "fail";
    } else {
        $resultStr = $result;
    }
    // log message
    db_add(
        TABLE_MAIL_LOG,
        array(
            "published" => 1,
            "user_id" => $_SESSION["user_id"],
            "to" => $to,
            "subject" => $subject,
            "body" => $body,
            "header" => $header,
            "result" => $resultStr,
        )
    );

    return $result;
}

/**
 * Send an email to $mailTo using template name $template
 * Current email provider is used
 * Additional parameters are passed using $data array
 *
 * @param string $template Name of a email template
 * @param string $mailTo Send to this email
 * @param array $data Optional Array with data for auto replacement
 * @param string $lang Optional Language of a template; defaults to LANG
 * @return boolean
 */
function msv_email_template($template, $mailTo, $data = array(), $lang = LANG) {
    // get template
    $template = msv_get_template($template,$data,  $lang);
    if (!empty($template)) {
        return msv_email($mailTo, $template["subject"], $template["text"]);
    } else {
        return false;
    }
}

/**
 * Get email $template
 * Additional parameters are passed using $data array
 * replace pattern: {email} into $data["email"]
 * replacement is done for both body and subject of email
 *
 * @param string $template Name of a email template
 * @param array $data Optional Array with data for auto replacement
 * @param string $lang Optional Language of a template; defaults to LANG
 * @return boolean
 */
function msv_get_template($template, $data = array(), $lang = LANG) {
    // get template
    $resultMail = db_get(TABLE_MAIL_TEMPLATES, " `name` = '" . db_escape($template) . "'", $lang);
    $template = $resultMail["data"];

    if (!$resultMail["ok"] || empty($template)) {
        return false;
    }

    $mailSubject = $template["subject"];
    $mailBody = $template["text"];

    msv_set_config("dataTemplate", $data);

    // replace pattern:
    // {email} into $data["email"]
    $mailBody = preg_replace_callback(
        '~\{(\w+?)\}~sU',
        create_function('$t', '
        $r = msv_get_config("dataTemplate");
        $retText = $t[0];
        if (defined($t[1])) {
            $retText = constant($t[1]);
        }
        $config = msv_get_config($t[1]);
        if (!empty($config)) {
            $retText = $config;
        }
        if (array_key_exists($t[1], $r)) {
            $retText = $r[$t[1]];
        }
        return $retText;
            '), $mailBody);

    $mailSubject = preg_replace_callback(
        '~\{(\w+?)\}~sU',
        create_function('$t', '
        $r = msv_get_config("dataTemplate");
        $retText = $t[0];
        if (defined($t[1])) {
            $retText = constant($t[1]);
        }
        $config = msv_get_config($t[1]);
        if (!empty($config)) {
            $retText = $config;
        }
        if (array_key_exists($t[1], $r)) {
            $retText = $r[$t[1]];
        }
        return $retText;
            '), $mailSubject);

    // add header HTML to a body
    if (!empty($template["header"])) {
        $mailBody = $template["header"] . $mailBody;
    }

    $template["subject"] = $mailSubject;
    $template["text"] = $mailBody;

    return $template;
}

/**
 * Generate a random password of a given length
 *
 * @param integer $length Length of password in characters
 * @return string Random password
 */
function msv_generate_password($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

/**
 * Search for IP information in array $_SERVER
 * Returns a string with IP for current request
 *
 * @return string
 */
function msv_get_ip() {

    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

/**
 * Generates sitemap using information from TABLE_SEO
 * File /sitemap.xml is updated
 *
 * @param bool $autoUpdate call in silent mode
 * @return bool
 */
function msv_genegate_sitemap($autoUpdate = false) {
    $sitemapPath = ABS."/sitemap.xml";

    if (!is_writable($sitemapPath)) {
        if (!$autoUpdate) {
            msv_message_error("Can't write to $sitemapPath");
        }
        return false;
    }

    $sitemapXML = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
';
    $website = msv_get("website");

    foreach ($website->languages as $langID) {
        $query = db_get_list(TABLE_SEO, "`sitemap` > 0", "`url` asc", 10000, 0,  $langID);
        if ($query["ok"] && $query["data"]) {
            foreach ($query["data"] as $item) {
                $sitemapXML .= "
<url>
<loc>".HOME_LINK.$item["url"]."</loc>
<priority>1</priority>
<lastmod>".date("Y-m-d", strtotime($item["updated"]))."</lastmod>
</url>\n";
            }
        }
    }

    $sitemapXML .= "</urlset>";
    return file_put_contents($sitemapPath, $sitemapXML);
}


function msv_highlight_text($s, $text, $c) {
    $text = strip_tags($text);
    $text = str_replace(array("&nbsp;","\n"), " ", $text);
    $text = array_map("trim", explode(" ", $text));

    $i = 0;
    $i_pos = 0;
    foreach ($text as $v) {
        if (!empty($v)) {
            $ar[] = $v;
            if (strstr($v, $s) && empty($i_pos)) $i_pos = $i;
            $i++;
        }
    }
    $i_pos = ($i_pos - $c) < 0 ? 0 : $i_pos - $c;
    for ($i = $i_pos; $i < ($c * 2 + $i_pos); $i++) {
        if (!empty($ar[$i])) $ar2[] = $ar[$i];
    }
    unset($ar);
    // var_dump(str_replace($s, "<strong>".$s."</strong>", implode(' ', $ar2)));
    // Создаем строку для регулярного выражения
    $pattern = "/((?:^|>)[^<]*)(".$s.")/si";
    // Подсвеченная строка
    $replace = '$1<span class="highlight">$2</span>';

    return (empty($ar2) ? "" :  preg_replace($pattern, $replace, implode(' ', $ar2)));
}


function msv_format_mimetype($mimeType) {
    $mapping = array(
        'pdf'   =>      array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'),
        'swf'   =>      'application/x-shockwave-flash',
        'zip'   =>      array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'),
        'rar'   =>      array('application/x-rar', 'application/rar', 'application/x-rar-compressed'),
        'gif'   =>      'image/gif',
        'jpg'   =>      array('image/jpeg', 'image/pjpeg'),
        'png'   =>      array('image/png',  'image/x-png'),
        'tif'   =>      'image/tiff',
    );
    if (($ext = array_search($mimeType, $mapping, TRUE))) {
        return $ext;
    }
    foreach ($mapping as $ext => $mimeList) {
        if (is_array($mimeList) && in_array($mimeType, $mimeList)) {
            return $ext;
        }
    }
    return false;
}

/**
 * Perfoms redirect to given URL
 *
 * @param string $url URL to redirect
 */
function msv_redirect($url) {
    $website = msv_get("website");

    // check lang URL
    if (!empty($website->langUrl)) {

        // only in case of local redirect
        if (substr($url, 0, 1) === '/' && strpos($url, $website->langUrl) !== 0) {
            $url = $website->langUrl.$url;
        }

    }

    $website->outputRedirect($url);
}

function msv_check_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL)
        && preg_match('/@.+\./', $email);
}

/**
 * Assign variable to template engine
 * Value of variable $dataName is set to $dataValue
 * Afterwards $dataName will be accessible for use in template
 *
 * @param string $dataName
 * @param string $dataValue
 * @return boolean Result of the action
 */
function msv_assign_data($dataName, $dataValue) {
    $website = msv_get("website");
    if (!$website) return false;

    $website->config[$dataName] = $dataValue;
    return true;
}

function msv_check_accessuser($pageAccess) {
    $rowUser = msv_get("website.user");
    if (empty($rowUser)) {
        return false;
    }
    $website = msv_get("website");
    return $website->checkAccess($pageAccess, $rowUser["access"]);
}

/**
 * Add "Edit" button for div's found by $selector
 * onclick opens adminModal with edit form for current item
 *
 * @param string $selector
 * @param string $section
 * @param string $table
 * @return boolean Result of the action
 */
function msv_admin_editbtn($selector, $section, $table) {
    if (!msv_check_accessuser("admin")) return false;



    $edit_mode = msv_get_config("edit_mode");
    if (!$edit_mode) return false;

    msv_include_js("
$(document).ready(function() {
    $('".$selector."').hover(function() {
       $(this).addClass('editor-inline-block').prepend('<a href=\"/admin/?section=".$section."&table=".$table."&edit='+$(this).attr('data-id')+'\" id=\"admin-edit-btn\">"._t("btn.click_to_edit")."</a>');
       $('#admin-edit-btn').addClass('admin-edit-overlay btn btn-danger').on('click', function(e){
        });
    }, function() {
       $(this).removeClass('editor-inline-block');
       $('#admin-edit-btn').remove();
    });
});
");

    // TODO: finish this feature
    // this is not yet working
    return true;

    msv_include_js("
$(document).ready(function() {
    $('".$selector."').hover(function() {
       $(this).addClass('editor-inline-block').prepend('<a href=\"/api/form/?section=".$section."&table=".$table."&edit='+$(this).attr('data-id')+'\" id=\"admin-edit-btn\">"._t("btn.click_to_edit")."</a>');
       $('#admin-edit-btn').addClass('admin-edit-overlay btn btn-danger').on('click', function(e){
            e.preventDefault();
            $('#adminModal').modal('show').find('#modal-frame').attr('src', $(this).attr('href'));
        });
    }, function() {
       $(this).removeClass('editor-inline-block');
       $('#admin-edit-btn').remove();
    });
});
");

    return true;
}


function msv_process_uploadpic($path, $table = "", $field = "") {
    $fileResult = "";
    $mimetype = "";

    if (empty($path)) {
        return "";
    }

    if (strpos($path, "http") === 0) {
        // this is remote file
        $pathLoad = $path;

        $headers = get_headers($path);
        if(strpos($headers[0],'200') === false) {
            foreach ($headers as $line) {
                if(strpos($line,'Content-Type: ') === 0) {
                    $mimetype = substr($line, 15);
                }
            }
        }
    } else {
        // local file
        $pathLoad = UPLOAD_FILES_PATH."/".$path;

        if (is_readable($pathLoad)) {
            $mimetype = mime_content_type($pathLoad);
        }
    }

    if (empty($mimetype)) {
        return "";
    }

    $fileResult = msv_store_pic($pathLoad, $mimetype, "", $table, $field);
    if (!is_numeric($fileResult)) {
        return $fileResult;
    }

    return "";
}

/**
 * Add new cron job
 * Database table: TABLE_CRONJOBS, TABLE_CRONJOBS_LOGS
 *
 * checks for required fields and correct values
 * $row["name"] is required
 * $row["url_local"] or $row["code"] is required
 *
 * @param array $row Associative array with data to be inserted
 * @param array $options Optional list of flags. Supported: none
 * @return array Result of a API call
 */
function msv_add_cron($row, $options = array()) {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // check required fields
    if (empty($row["name"])) {
        $result["msg"] = _t("msg.cron.noname");
        return $result;
    }
    if (empty($row["url_local"]) && empty($row["code"])) {
        $result["msg"] = _t("msg.cron.noaction");
        return $result;
    }

    // set defaults
    if (empty($row["published"])) {
        $row["published"] = 1;
    } else {
        $row["published"] = (int)$row["published"];
    }

    // set empty fields
    if (empty($row["url_local"])) $row["url_local"] = "";
    if (empty($row["code"])) $row["code"] = "";
    if (empty($row["status"])) $row["status"] = "disabled";
    if (empty($row["type"])) $row["type"] = "";

    $result = db_add(TABLE_CRONJOBS, $row);

    if ($result["ok"]) {
        $result["msg"] = _t("msg.cron.saved");
    }

    // write to a cron log
    $itemLog = array(
        "published" => 1,
        "job_id" => (int)$result["insert_id"],
        "job_name" => $row["name"],
        "result_ok" => $result["ok"],
        "result_msg" => $result["msg"],
    );

    db_add(TABLE_CRONJOBS_LOGS, $itemLog);

    return $result;
}

function msv_update_allmodules() {
    if (!msv_check_accessuser("dev")) {
        return false;
    }

    $list = msv_get("website.modules");
    foreach($list as $moduleName) {
        msv_reinstall_module($moduleName, false);
    }

    msv_message_ok("Update ALL successfully");
    return true;
}

/**
 * Format string to create an URL
 * translits cyrilic and skip all non latic chars.
 *
 * @param string $string Input string
 * @return string Formated string
 */
function msv_format_url($string) {
    $trans_fwd = array(
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d',
        'е'=>'e','є'=>'e','ё'=>'e','ж'=>'zh','з'=>'z',
        'и'=>'i','і'=>'i','ї'=>'i','й'=>'y','к'=>'k',
        'л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p',
        'р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f',
        'х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'sch',
        'ъ'=>'','ы'=>'i','ь'=>'','э'=>'e','ю'=>'yu',
        'я'=>'ya',' '=>'-','-'=>'-','0'=>'0','1'=>'1',
        '2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6',
        '7'=>'7','8'=>'8','9'=>'9','_'=>'-','('=>'',
        ')'=>'','a'=>'a','b'=>'b','c'=>'c','d'=>'d',
        'e'=>'e','f'=>'f','g'=>'g','h'=>'h','i'=>'i',
        'j'=>'j','k'=>'k','l'=>'l','m'=>'m','n'=>'n',
        'o'=>'o','p'=>'p','q'=>'q','r'=>'r','s'=>'s',
        't'=>'t','u'=>'u','v'=>'v','w'=>'w','x'=>'x',
        'y'=>'y','z'=>'z'
    );
    $result = '';
    $string = mb_strtolower($string, 'utf-8');
    for ($i = 0; $i < mb_strlen($string, 'utf-8'); $i++) {
        $letter = mb_substr($string, $i, 1, 'utf-8');
        if ($trans_fwd[$letter] !== NULL) {
            $result .= $trans_fwd[$letter];
        } else {
            $result .= '';
        }
    }
    return $result;
}

/**
 * 'Smart' string truncate
 * tryes to find space or coma near to a cut possition to avoid word break
 *
 * @param string $str Input string
 * @param int $max_chars Chars limit
 * @return string Truncated string
 */
function msv_truncate_text($str, $max_chars = 30) {
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

function msv_load_module_doc($pathModule, $docName) {
    $content = "";

    $path = $pathModule."doc/".LANG."-".$docName.".html";

    // try to fall back to eng
    if (!is_readable($path)) {
        $path = $pathModule."doc/en-".$docName.".html";
    }

    if (is_readable($path)) {
        $content = file_get_contents($path);

        $content = preg_replace_callback(
            '~\{(\w+?)\}~sU',
            create_function('$t','
                        if (defined($t[1])) {
                            return constant($t[1]);
                        } else {
                            return "{".$t[1]."}";
                        };
                    '),
            $content);

        return $content;
    } else {
        msv_message_error("File not found: $path");
    }

    return $content;
}
