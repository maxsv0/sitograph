<?php

/**
 * Add CSS or JS file directly to website output
 * File is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_Include($filePath, $url = '', $access = 'everyone') {
    if (!MSV_checkInclude($url, $access)) {
        return false;
    }

    // TODO: rework this check
    // detect if $filePath is remote or local file
    // and determine file extension
    if (strpos($filePath, "http") === 0) {
        $type = substr($filePath, strrchr($filePath, ".")+1);
    } else {
        $type = pathinfo($filePath, PATHINFO_EXTENSION);
    }

    switch ($type) {
        case "css":
            MSV_IncludeCSSFile($filePath, $url, $access);
            break;

        case "js":
            MSV_IncludeJSFile($filePath, $url, $access);
            break;

        default:
            return false;
    }

    return true;
}

/**
 * Add CSS file directly to website output
 * File is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_IncludeCSSFile($filePath, $url = '', $access = 'everyone') {
    $website =& MSV_get("website");

    //TODO check $filePath if correct path/url

    if (!MSV_checkInclude($url, $access)) {
        return false;
    }

    if (!in_array($filePath, $website->includeCSS)) {
        $website->includeCSS[] = $filePath;
    }

    return true;
}

/**
 * Add JS file directly to website output
 * File is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $filePath
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_IncludeJSFile($filePath, $url = '', $access = 'everyone') {
    $website =& MSV_get("website");

    //TODO check $filePath if correct path/url

    if (!MSV_checkInclude($url, $access)) {
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
function MSV_checkInclude($url = '', $access = 'everyone') {
    $website =& MSV_get("website");

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
 * code is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $cssCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_IncludeCSS($cssCode, $url = '', $access = 'everyone') {
    $website =& MSV_get("website");

    if (!MSV_checkInclude($url, $access)) {
        return false;
    }

    $website->includeCSSCode .= "\n".$cssCode;

    return true;
}

/**
 * Add JS code directly to website output
 * code is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $jsCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_IncludeJS($jsCode, $url = '', $access = 'everyone') {
    $website =& MSV_get("website");

    if (!MSV_checkInclude($url, $access)) {
        return false;
    }

    $website->includeJSCode .= "\n".$jsCode;

    return true;
}

/**
 * Add HTML code directly to website output
 * code is only added if MSV_checkInclude($url, $access) is passed
 *
 * @param string $htmlCode
 * @param string $url Optional URL where this code should be added
 * @param string $access Optional Level of access; defaults to 'everyone'
 * @return boolean
 */
function MSV_IncludeHTML($htmlCode, $url = '', $access = 'everyone') {
    $website =& MSV_get("website");

    if (!MSV_checkInclude($url, $access)) {
        return false;
    }

    $website->includeHTMLCode .= "\n".$htmlCode;

    return true;
}

function MSV_Log($logText = "", $type = "warning") {
    $website =& MSV_get("website");

    $website->log($logText, $type);

    return true;
}

/**
 * Adds 'success' message to website output
 *
 * @param string $messageText Optional Text of a message
 * @return boolean
 */
function MSV_MessageOK($messageText = "") {
    if (empty($messageText)) return false;

    $website =& MSV_get("website");
    $website->messages["success"][] = $messageText;

    return true;
}

/**
 * Adds 'error' message to website output
 *
 * @param string $messageText Optional Text of a message
 * @return boolean
 */
function MSV_MessageError($messageText = "") {
    if (empty($messageText)) return false;

    $website =& MSV_get("website");
    $website->messages["error"][] = $messageText;

    return true;
}

/**
 * Returns true if website has any 'error' messages
 *
 * @return boolean
 */
function MSV_HasMessageError() {
    $website = MSV_get("website");

    if (!empty($website->messages["error"])) {
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
function MSV_Error($errorText = "") {
    $website = MSV_get("website");

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
function MSV_setNavigation($name, $url = "", $pos = false) {
    $website = MSV_get("website");

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

}

function MSV_setConfig($param, $value, $updateDB = false, $lang = LANG) {
    $website =& MSV_get("website");

    // TODO : CHECK ...
    if (array_key_exists($param, $website->config)) {
        $website->config[$param] = $value;

        if ($updateDB) {
            return API_updateDBItem(TABLE_SETTINGS, "value", "'".MSV_SQLEscape($value)."'", " `param` = '".$param."'");
        }
    } else {
        $website->config[$param] = $value;

        if ($updateDB) {
            $item = array(
                "published" => 1,
                "value" => $value,
                "param" => $param,
            );

            return API_itemAdd(TABLE_SETTINGS, $item, $lang);
        }
    }

    return true;
}

/**
 * Searches for config value with name $param
 *
 * @param string $param Name of the config parameter
 * @return mixed
 */
function MSV_getConfig($param) {
    $website = MSV_get("website");

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
function MSV_getTableConfig($table) {
    //TODO  add some check

    $tablesList = MSV_get("website.tables");

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
function MSV_SQLRow($sqlQuery) {

    $row = mysqli_fetch_assoc($sqlQuery);

    return $row;
}

/**
 * Escape SQL code for current DB connection
 *
 * @param string $string SQL code
 * @return string
 */
function MSV_SQLEscape($string) {

    $website = MSV_get("website");

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
function MSV_storeFile($url, $type = "jpg", $name = "", $table = "", $field = "") {

    $typeExt = MSV_formatMimeType($type);
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
 * Original file is stored using MSV_storeFile function
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
function MSV_storePic($url, $type = "jpg", $name = "", $table = "", $field = "") {

    $typeExt = MSV_formatMimeType($type);
    if (!empty($typeExt)) {
        $type = $typeExt;
    }

    // store original file
    $fileResult = MSV_storeFile($url, $type, $name, $table, $field);

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
        $tablesList = MSV_get("website.tables");
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
 * usage: MSV_get('website.tables'), MSV_get('website.api')
 *
 * @param string $param Optional Name/path of the object to be returned; defaults to 'website'
 * @return mixed
 */
function &MSV_get($param = "website") {

    global $website;
    if (empty($website)) {
        // TODO: ???
        die(".");
    }

    $returnObj = null;

    $arPath = explode(".", $param);
    if (count($arPath) > 1) {

        $item = $arPath[1];

        $returnObj =& $website->{$item};
    } else {
        $returnObj =& $website;
    }

    return $returnObj;
}

function MSV_checkFiles() {
    $website = MSV_get("website");


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
        if (strpos($file, ".git") !== false) continue;
        $fileList[] = $file;
    }

    foreach ($fileList as $file) {
        echo "$file ";
        if (array_key_exists($file, $fileModuleList)) {
            echo "<span style='color:green;'>".$fileModuleList[$file]." - ok</span>";
        } else {
            echo "<span style='color:red;'>NOT FOUND</span>";
        }
        echo "<br>";
    }
}

/**
 * Assign the data from request to template engine adding name prefix
 *
 * @param string $table
 * @param string $prefix Optional; defaults to ''
 * @return boolean Result of the action
 */
function MSV_assignTableData($table, $prefix = "") {
    $tableInfo = MSV_getTableConfig($table);

    if (empty($tableInfo)) {
        return false;
    }

    foreach ($tableInfo["fields"] as $item) {
        if (!array_key_exists($prefix.$item["name"], $_REQUEST)) {
            MSV_assignData($prefix.$item["name"], $_REQUEST[$prefix.$item["name"]]);
        }
    }

    return true;
}

function MSV_DataFormat($table, $dataRow) {
    //TODO ...

    $tablesList = MSV_get("website.tables");

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

function MSV_proccessTableData($table, $prefix = "") {
    $tableInfo = MSV_getTableConfig($table);
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
                    $rowInfo = MSV_get("website.user");
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
                if (!empty($value)) {
                    if (strpos($value, CONTENT_URL) === 0) {
                        $value = substr($value, strlen(CONTENT_URL)+1);
                    }
                    $dataItem[$item["name"]] = $value;
                } else {
                    if (array_key_exists($prefix.$item["name"], $_FILES)) {
                        $type = $_FILES[$prefix.$item["name"]]["type"];
                        $path = $_FILES[$prefix.$item["name"]]["tmp_name"];
                        $name = $_FILES[$prefix.$item["name"]]["name"];
                        $typeExt = MSV_formatMimeType($type);
                        if (!empty($typeExt)) {
                            // store file
                            if ($item["type"] === "pic") {
                                $fileResult = MSV_storePic($path, $typeExt, $name, $table, $item["name"]);
                            } else {
                                $fileResult = MSV_storeFile($path, $typeExt, $name, $table, $item["name"]);
                            }
                            if (!is_numeric($fileResult)) {
                                $dataItem[$item["name"]] = $fileResult;
                            } else {
                                // error storing file
                            }
                        }
                    }
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
                    $dataItem[$item["name"]] = date("Y-m-d H:i:s", $value);
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
                MSV_MessageError("Unknown data type: ".$item["type"]);
                break;
        }
    }

    return $dataItem;
}

function MSV_proccessUpdateTable($table, $prefix = "") {
    $result = array(
        "ok" => false,
        "data" => array(),
        "msg" => "",
    );

    // extract data from request for corresponding table
    $item = MSV_proccessTableData($table, $prefix);

    if (empty($item)) {
        $result["msg"] = "Can't validate input data";
        return $result;
    }

    $result = API_updateDBItemRow($table, $item);
    return $result;
}

/**
 * Format a size in bytes, adding corresponding units of measure
 * Returns formatted string
 *
 * @param integer $size Size in bytes to be formatted
 * @return string Formatted string
 */
function MSV_formatSize($size) {
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
    $website = MSV_get("website");

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
function MSV_Structure_add($row, $options = array()) {
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
        $website = MSV_get("website");

        $n = 0;
        foreach ($website->languages as $langID) {
            $optionsLang = $options;
            $optionsLang["lang"] = $langID;
            MSV_Structure_add($row, $optionsLang);
            $n++;
        }

        $result["msg"] = "Recursively called $n times";
        $result["ok"] = true;
        return $result;
    }

    $parent_id = 0;
    if (!empty($row["parent_url"])) {
        $resultParent = API_getDBItem(TABLE_STRUCTURE, "`url` = '".MSV_SQLEscape($row["parent_url"])."'", $lang);
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

    $result = API_itemAdd(TABLE_STRUCTURE, $row, $lang);

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
        SEO_add($itemSEO, array("lang" => $lang));

        // add document
        if (!empty($row["document_title"]) || !empty($row["document_text"])) {
            $itemDocument = array(
                "name" => $row["document_title"],
                "text" => $row["document_text"],
            );
            $resultDocument = MSV_Document_add($itemDocument, array("lang" => $lang));

            // update structure=>set document
            if ($resultDocument["ok"]) {
                API_updateDBItem(TABLE_STRUCTURE, "page_document_id", $resultDocument["insert_id"], " id = '".$structure_id."'");
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
            API_itemAdd(TABLE_MENU, $item, $lang);
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
function MSV_Document_add($row, $options = array()) {
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

    $result = API_itemAdd(TABLE_DOCUMENTS, $row, $lang);

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
function MSV_MailTemplate_add($row, $options = array()) {
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

    $result = API_itemAdd(TABLE_MAIL_TEMPLATES, $row, $lang);

    return $result;
}

/**
 * Send an email using mail() function
 * MSV_getConfig("email_from") and MSV_getConfig("email_fromname") is used in FROM field
 * Additional header is added with $header
 * Content-type is set to text/html
 *
 * @param string $to Send to this email
 * @param string $subject Subject of an email
 * @param string $body Optional Email body can be HTML or plain text
 * @param string $header Optional Additional header
 * @return boolean
 */
function MSV_EmailDefault($to = "", $subject = "", $body = "", $header = "") {

    $emailFrom = MSV_getConfig("email_from");
    $emailFromName = MSV_getConfig("email_fromname");
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
 * MSV_getConfig("email_from") and MSV_getConfig("email_fromname") is used in FROM field
 * Additional header is added with $header
 *
 * @param string $to Send to this email
 * @param string $subject Subject of an email
 * @param string $body Optional Email body can be HTML or plain text
 * @param string $header Optional Additional header
 * @return boolean
 */
function MSV_Email($to = "", $subject = "", $body = "", $header = "") {
    // get Mailer function
    $mailer = MSV_getConfig("mailer");

    return call_user_func_array($mailer, array($to, $subject, $body, $header));
}

/**
 * Send an email to $mailTo using template name $template
 * Current email provider is used
 * Additional parameters are passed using $data array
 * replace pattern: {email} into $data["email"]
 * replacement is done for both body and subject of email
 *
 * @param string $template Name of a email template
 * @param string $mailTo Send to this email
 * @param array $data Optional Array with data for auto replacement
 * @param boolean $message Optional Flag to add result message to output; defaults to true
 * @param string $lang Optional Language of a template; defaults to LANG
 * @return boolean
 */
function MSV_EmailTemplate($template, $mailTo, $data = array(), $message = true, $lang = LANG) {

    // get template
    $resultMail = API_getDBItem(TABLE_MAIL_TEMPLATES, " `name` = '".MSV_SQLEscape($template)."'", $lang);

    if ($resultMail["ok"] && !empty($resultMail["data"])) {
        $mailSubject = $resultMail["data"]["subject"];
        $mailBody = $resultMail["data"]["text"];

        MSV_setConfig("dataTemplate", $data);

        // replace pattern:
        // {email} into $data["email"]
        $mailBody = preg_replace_callback(
            '~\{(\w+?)\}~sU',
            create_function('$t','
            $r = MSV_getConfig("dataTemplate");
            $retText = $t[0];
            if (defined($t[1])) {
                $retText = constant($t[1]);
            }
            $config = MSV_getConfig($t[1]);
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
            create_function('$t','
            $r = MSV_getConfig("dataTemplate");
            $retText = $t[0];
            if (defined($t[1])) {
                $retText = constant($t[1]);
            }
            $config = MSV_getConfig($t[1]);
            if (!empty($config)) {
                $retText = $config;
            }
            if (array_key_exists($t[1], $r)) {
                $retText = $r[$t[1]];
            }
            return $retText;
                '), $mailSubject);

        // add header HTML to a body
        if (!empty($resultMail["data"]["header"])) {
            $mailBody = $resultMail["data"]["header"].$mailBody;
        }

        return MSV_Email($mailTo, $mailSubject, $mailBody);
    } else {
        return false;
    }
}

/**
 * Generate a random password of a given length
 *
 * @param integer $length Length of password in characters
 * @return string Random password
 */
function MSV_PasswordGenerate($length = 12) {
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
function MSV_GetIP() {

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
 * @return boolean
 */
function MSV_SitemapGenegate() {
    $sitemapPath = ABS."/sitemap.xml";

    if (!is_writable($sitemapPath)) {
        MSV_MessageError("Can't write to $sitemapPath");
        return false;
    }

    $sitemapXML = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
';
    $website = MSV_get("website");

    foreach ($website->languages as $langID) {
        $query = API_getDBList(TABLE_SEO, "`sitemap` > 0", "`url` asc", 10000, 0,  $langID);
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


function MSV_HighlightText($s, $text, $c) {
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


function MSV_formatMimeType($mimeType) {
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
function MSV_redirect($url) {
    $website = MSV_get("website");

    // check lang URL
    if (!empty($website->langUrl)) {

        // only in case of local redirect
        if (substr($url, 0, 1) === '/' && strpos($url, $website->langUrl) !== 0) {
            $url = $website->langUrl.$url;
        }

    }

    $website->outputRedirect($url);
}

function MSV_checkEmail($email) {
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
function MSV_assignData($dataName, $dataValue) {
    $website = MSV_get("website");
    if (!$website) return false;

    $website->config[$dataName] = $dataValue;
    return true;
}

function MSV_checkAccessUser($pageAccess) {
    $rowUser = MSV_get("website.user");
    if (empty($rowUser)) {
        return false;
    }
    $website = MSV_get("website");
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
function MSV_addAdminEdit($selector, $section, $table) {
    if (!MSV_checkAccessUser("admin")) return false;



    $edit_mode = MSV_getConfig("edit_mode");
    if (!$edit_mode) return false;

    MSV_IncludeJS("
$(document).ready(function() {
    $('".$selector."').hover(function() {
       $(this).addClass('editor-inline-block').prepend('<a href=\"/admin/?section=".$section."&table=".$table."&edit='+$(this).attr('data-id')+'\" id=\"admin-edit-btn\">Click to edit</a>');
       $('#admin-edit-btn').addClass('admin-edit-overlay btn btn-warning').on('click', function(e){
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

    MSV_IncludeJS("
$(document).ready(function() {
    $('".$selector."').hover(function() {
       $(this).addClass('editor-inline-block').prepend('<a href=\"/api/form/?section=".$section."&table=".$table."&edit='+$(this).attr('data-id')+'\" id=\"admin-edit-btn\">Click to edit</a>');
       $('#admin-edit-btn').addClass('admin-edit-overlay btn btn-warning').on('click', function(e){
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


function MSV_processUploadPic($path, $table = "", $field = "") {
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

    $fileResult = MSV_storePic($pathLoad, $mimetype, "", $table, $field);
    if (!is_numeric($fileResult)) {
        return $fileResult;
    }

    return "";
}