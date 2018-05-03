<?php

/**
 * Execute SQL code
 * Current DB connection is used
 * In case of success returns insert_id and affected rows number
 *
 * @param string $sqlCode SQL code to execute
 * @return array API result of action
 */
function db_sql($sqlCode) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    msv_log("SQL: $sqlCode", "debug");

    $website = msv_get("website");

    // exit if DB connection doest not exist
    if (!$website->config["db"]) {
        $result["ok"] = false;
        $result["msg"] = "DB connection is not active.";
        return $result;
    }
    $query = mysqli_query($website->config["db"], $sqlCode);

    $result["data"] = $query;

    if ($query) {
        $result["msg"] = "Success.";

        $result["insert_id"] = mysqli_insert_id($website->config["db"]);
        $result["affected"] = mysqli_affected_rows($website->config["db"]);

        if (!empty($result["insert_id"])) {
            $result["msg"] .= " Insert ID ".$result["insert_id"].".";
        }
        if (!empty($result["affected"])) {
            $result["msg"] .= " Affected rows: ".$result["affected"].".";
        }
    } else {
        $result["ok"] = false;
        $result["msg"] = mysqli_error($website->config["db"]);

        if (DEBUG) {
            $str = "*** ERROR: ".$result["msg"];
            msv_log($str, "debug");
        }
    }

    $result["sql"] = $sqlCode;
    return $result;
}

/**
 * Update row in database
 *
 * SQL template:
INSERT into `$table` (
...
values (
...
)
ON DUPLICATE KEY UPDATE
...
 *
 * @param string $table Table name in database
 * @param array $row Associative array with data
 * @return array API result of action
 */
function db_update_row($table, $row) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    // get list of tables and check $table
    $tablesList = msv_get("website.tables");
    if (!array_key_exists($table, $tablesList)) {
        $result["ok"] = false;
        $result["msg"] = _t("msg.table_not_found").": $table";

        return $result;
    }

    // get table info
    $infoTable = $tablesList[$table];

    // set update date
    $row["updated"] = date("Y-m-d H:i:s");

    // build query parts
    $sqlCodeField = $sqlCodeValue = $sqlCodeUpdate = "";
    $indexValue = '';

    foreach ($row as $field => $value) {
        $type = $infoTable["fields"][$field]["type"];
        $sqlCodeField .= " `".$field."`,";

        if ($type === "id") {
            $indexValue = $value;
        }
        if ($type === "url" && empty($value)) {
            if (empty($indexValue)) {
                $value = "----------";
                if (!empty($row["name"])) {
                    $value = msv_format_url($row["name"]);
                } elseif (!empty($row["title"])) {
                    $value = msv_format_url($row["title"]);
                }
            } else {
                $value = $indexValue;
            }
        }
        if ($type === "array" || $type === "multiselect") {
            $value = serialize($value);
        }

        if ($type === "bool"             ||
            $type === "int"              ||
            $type === "select"           ||
            $type === "published"        ||
            $type === "deleted"          ||
            $type === "int"
        ) {
            $sqlCodeValue .= "".(int)$value.",";
            $sqlCodeUpdate .= " `".$field."` = ".(int)$value.", ";
        } else {
            if (strtoupper($value) == "NULL") {
                $sqlCodeValue .= "NULL,";
                $sqlCodeUpdate .= " `".$field."` = NULL, ";
            } else {
                $sqlCodeValue .= "'".db_escape($value)."',";
                $sqlCodeUpdate .= " `".$field."` = '".db_escape($value)."', ";
            }
        }
    }
    $sqlCodeField = substr($sqlCodeField, 0, -1)." ) ";
    $sqlCodeValue = substr($sqlCodeValue, 0, -1)." ) ";
    $sqlCodeUpdate = substr($sqlCodeUpdate, 0, -2)." ; ";

    // Build SQL query
    $sqlCode = "INSERT into `$table` ( ";
    $sqlCode .= $sqlCodeField;
    $sqlCode .= " values (";
    $sqlCode .= $sqlCodeValue;
    $sqlCode .= " ON DUPLICATE KEY UPDATE ";
    $sqlCode .= $sqlCodeUpdate;

    msv_log("db_update_row for table $table");

    return db_sql($sqlCode);
}

/**
 * Update single value for table in database
 *
 * SQL template:
update `$table`
set
`$param` = $value
where
$filter
 *
 * @param string $table Table name in database
 * @param string $param Name of a field in DB
 * @param string $value Value to insert into DB
 * @param string $filter SQL code after `where` clause
 * @return array API result of action
 */
function db_update($table, $param, $value, $filter = "", $lang = LANG) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    // TODO: check $param

    $sqlCode = "update `$table`  ";
    $sqlCode .= " set ";
    $sqlCode .= " `$param` = ".$value." ";
    $sqlCode .= " where";
    $sqlCode .= " (`lang` = '".$lang."' or `lang` = '*') ";
    if (!empty($filter)) {
        $sqlCode .= " and ";
        $sqlCode .= $filter;
    }

    msv_log("db_update for table $table, $param, $value, $filter");

    return db_sql($sqlCode);
}

/**
 * Update row in DB to mark it as deleted
 *
 * @param string $table Table name in database
 * @param string $filter SQL code after `where` clause
 * @return array API result of action
 */
function db_delete($table, $filter = "") {

    $updateResult = db_update($table, "published", 0, $filter);
    if ($updateResult["ok"]) {
        return db_update($table, "deleted", 1, $filter);
    }
}

/**
 * Get list of data from database, splitted into pages
 *
 * @param string $table Table name in database
 * @param string $filter SQL code after `where` clause
 * @param string $orderby SQL code after `order by` clause
 * @param int $items_per_page Number of items to retrieve
 * @param string $page_url_param URL parameter of paging list
 * @return array API result of action
 */
function db_get_listpaged($table, $filter = "", $orderby = "", $items_per_page = 10, $page_url_param = "p") {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    $items_per_page = (int)$items_per_page;
    if ($items_per_page <= 0) return false;

    if (empty($page_url_param)) {
        $page_url_param = "p";
    }

    $currentPage = (int)$_GET[$page_url_param]+1;
    $skip = ($currentPage - 1)*$items_per_page;

    $resultCount = db_get_count($table, $filter);

    if (!$resultCount["ok"]) {
        return $resultCount;
    }
    $num_rows = $resultCount["data"];
    if ($num_rows === 0) {
        return $resultCount;
    }

    $result["count_total"] = $num_rows;

    $resultList = db_get_list($table, $filter, $orderby, $items_per_page, $skip);
    if (!$resultList["ok"]) {
        return $resultList;
    }

    $result["count_data"] = min($items_per_page, count($resultList["data"]));

    $listPages = array();
    $pages = array();

    if ($num_rows > $items_per_page) {
        $max_page = ceil($num_rows/$items_per_page);

        $startPage = 0;
        if ($currentPage > 5) {
            $startPage = $currentPage - 5;
        }
        if ($max_page - $startPage > 15) {
            $max_page = $startPage + 15;
        }

        for ($i = $startPage; $i < $max_page; $i++) {
            $listPages[] = array(
                "name" => ($i+1),
                "url" => "?".($page_url_param)."=$i",
                "page" => ($i),
            );
        }

        $pages["current"] = array(
            "page" => $currentPage-1,
            "url" => "?".($page_url_param)."=".$currentPage,
        );;
        if ($currentPage > 1) {
            $pages["last"] = array(
                "page" => $max_page,
                "url" => "?".($page_url_param)."=".$max_page,
            );
            $pages["prev"] = array(
                "page" => $currentPage-2,
                "url" => "?".($page_url_param)."=".($currentPage-2),
            );
        } else {
            $pages["last"] = array(
                "page" => 1,
                "url" => "",
            );
            $pages["prev"] = false;
        }

        if ($currentPage < $max_page) {
            $pages["next"] = array(
                "page" => $currentPage+1,
                "url" => "?".($page_url_param)."=".($currentPage),
            );
        } else {
            $pages["next"] = false;
        }
    }
    if (!empty($listPages)) {
        $pages["pages"] = $listPages;
    }

    $result["pages"] = $pages;
    $result["data"] = $resultList["data"];

    return $result;
}

/**
 * Get row of data from DB
 *
 * @param string $table Table name in database
 * @param string $filter SQL code after `where` clause
 * @param string $lang LANG of data
 * @return array API result of action
 */
function db_get($table, $filter = "", $lang = LANG) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    // TODO: clear input: (int), mysql_real_escape_string
    // TODO: check if $table in conf.

    $sqlCode = "select * from `$table` where ";

    // Not published content is available only in Admin UI
    $user = msv_get("website.user");
    $request = msv_get("website.requestUrl");
    if (!($request === ADMIN_URL) && ($user["access"] === "dev" || $user["access"] === "admin")) {
        $sqlCode .= " `published` > 0 and ";
    }

    $sqlCode .= " `deleted` = 0 and  ";
    $sqlCode .= " (`lang` = '".$lang."' or `lang` = '*') ";

    if (!empty($filter)) {
        $sqlCode .= " and ";
        $sqlCode .= $filter;
    }

    $resultQuery = db_sql($sqlCode);
    if (!$resultQuery["ok"]) {
        $result["ok"] = false;
        $result["msg"] = _t("msg.cant_load_table_data")." `$table`. ";
        if (DEBUG) {
            $result["msg"] .= $resultQuery["msg"];
        }

        return $result;
    }

    if(mysqli_num_rows($resultQuery["data"]) === 0) {
        $result["msg"] = _t("msg.empty_result");
        $result["data"] = array();
        return $result;
    }

    $resultRow = db_fetch_row($resultQuery["data"]);
    if (!$resultRow) {
        $result["ok"] = false;
        $result["msg"] = _t("msg.cant_get_table_data")." `$table`";
        return $result;
    }

    $rowFormated = msv_format_data($table, $resultRow);

    $result["data"] = $rowFormated;

    return $result;
}

/**
 * Get count of rows in table
 *
 * @param string $table Table name in database
 * @param string $filter SQL code after `where` clause
 * @param string $lang LANG of data
 * @return array API result of action
 */
function db_get_count($table, $filter = "", $lang = LANG) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );

    $sqlCode = "select count(*) total from `$table` where";

    // Not published content is available only in Admin UI
    $user = msv_get("website.user");
    $request = msv_get("website.requestUrl");
    if (!(($request === ADMIN_URL) && ($user["access"] === "dev" || $user["access"] === "admin"))) {
        $sqlCode .= " `published` > 0 and ";
    }

    $sqlCode .= " `deleted` = 0  and ";
    $sqlCode .= " (`lang` = '".$lang."' or `lang` = '*')  ";
    if (!empty($filter)) {
        $sqlCode .= " and ";
        $sqlCode .= $filter;
    }

    $resultQuery = db_sql($sqlCode);
    if (!$resultQuery["ok"]) {
        return $resultQuery;
    }

    $row = mysqli_fetch_assoc($resultQuery["data"]);

    // replace 'data' with actual count
    $resultQuery["data"] = (int)$row["total"];

    return $resultQuery;
}

/**
 * Get list of data from database
 *
 * @param string $table Table name in database
 * @param string $filter SQL code after `where` clause
 * @param string $orderby SQL code after `order by` clause
 * @param int $limit Number of items to retrieve
 * @param int $skip Number of items to skip from start
 * @param string $lang LANG of data
 * @return array API result of action
 */
function db_get_list($table, $filter = "", $orderby = "", $limit = 1000000, $skip = 0, $lang = LANG) {
    // function returns $result
    $result = array(
        "ok" => true,
        "data" => array(),
        "msg" => "",
    );
    $skip = (int)$skip;
    if ($skip < 0) {
        $result["msg"] = "Error input";
        $result["data"] = array();
        return $result;
    }

    $tablesList = msv_get("website.tables");
    if (!array_key_exists($table, $tablesList)) {
        $result["msg"] = "Table not found $table";
        $result["data"] = array();
        return $result;
    }
    $infoTable = $tablesList[$table];
    $tableIndex = $infoTable["index"];

    // TODO: clear input: (int),mysql_real_escape_string
    // TODO: check if $table in conf.

    $sqlCode = "select * from `$table` where";

    // Not published content is available only in Admin UI
    $user = msv_get("website.user");
    $request = msv_get("website.requestUrl");
    if (!(($request === ADMIN_URL) && ($user["access"] === "dev" || $user["access"] === "admin"))) {
        $sqlCode .= " `published` > 0 and ";
    }

    // TODO: allow displaying deleted content in
    $sqlCode .= " `deleted` = 0  and ";
    $sqlCode .= " (`lang` = '".$lang."' or `lang` = '*')  ";

    $filter = trim($filter);
    if (!empty($filter)) {
        $sqlCode .= " and ";
        $sqlCode .= $filter;
    }
    if (!empty($orderby)) {
        $sqlCode .= " order by $orderby";
    } else {
        // TODO: get table $table index
        $sqlCode .= " order by `id` desc";
    }
    if (!empty($limit)) {
        $sqlCode .= " limit $skip, $limit ";
    } else {
        $sqlCode .= " limit 0, 5 ";
    }

    $result["sql"] = $sqlCode;

    $resultQuery = db_sql($sqlCode);
    if (!$resultQuery["ok"]) {
        $result["ok"] = false;
        $result["msg"] = _t("msg.cant_load_table_data")." `$table`. ".$resultQuery["msg"];
        return $result;
    }

    if(mysqli_num_rows($resultQuery["data"]) === 0) {
        $result["msg"] = "Empty result";
        $result["data"] = array();
        return $result;
    }

    $listItem = array();
    while ($resultRow = db_fetch_row($resultQuery["data"])) {
        // format row
        $rowFormated = msv_format_data($table, $resultRow);

        // add formated row to list
        $listItem[$rowFormated["id"]] = $rowFormated;
    }
    $result["data"] = $listItem;

    $result["count_total"] = $result["count_data"] = mysqli_num_rows($resultQuery["data"]);

    return $result;
}

/**
 * Drop table
 *
 * @param string $table Table name in database
 * @return array API result of action
 */
function db_remove_table($table) {
    $tablesList = msv_get("website.tables");
    $infoTable = $tablesList[$table];
    if (empty($infoTable)) {
        return false;
    }

    $sqlCode = "DROP TABLE `$table`";

    $result = db_sql($sqlCode);

    return $result;
}

/**
 * Truncate table
 *
 * @param string $table Table name in database
 * @return array API result of action
 */
function db_empty_table($table) {
    $tablesList = msv_get("website.tables");
    $infoTable = $tablesList[$table];
    if (empty($infoTable)) {
        return false;
    }

    $sqlCode = "TRUNCATE TABLE `$table`";

    $result = db_sql($sqlCode);

    return $result;
}

/**
 * Create table with indexes
 *
 * @param string $table Table name in database
 * @return array API result of action
 */
function db_create_table($table) {
    $tablesList = msv_get("website.tables");
    $infoTable = $tablesList[$table];
    if (empty($infoTable)) {
        return false;
    }

    $tableIndexes = array();

    $sqlCode = "CREATE TABLE `$table` ( ";
    foreach ($infoTable["fields"] as $field) {
        switch ($field["type"]) {
            case "id":
                $sqlCode .= " `".$field["name"]."` INT NOT NULL AUTO_INCREMENT ";
                break;
            case "int":
            case "select":
            case "published":
            case "deleted":
            case "bool":
                $sqlCode .= " `".$field["name"]."` INT NOT NULL DEFAULT 0 ";
                $tableIndexes[] = $field["name"];
                break;
            case "float":
                $sqlCode .= " `".$field["name"]."` FLOAT NOT NULL DEFAULT 0 ";
                break;
            case "url":
                $sqlCode .= " `".$field["name"]."` VARCHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                $tableIndexes[] = $field["name"];
                break;
            case "author":
                $sqlCode .= " `".$field["name"]."` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                $tableIndexes[] = $field["name"];
                break;
            case "lang":
                $sqlCode .= " `".$field["name"]."` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                $tableIndexes[] = $field["name"];
                break;
            case "str":
            case "file":
            case "pic":
                $sqlCode .= " `".$field["name"]."` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                break;
            case "text":
            case "array":
            case "multiselect":
                $sqlCode .= " `".$field["name"]."` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                break;
            case "doc":
                $sqlCode .= " `".$field["name"]."` MEDIUMTEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL ";
                break;
            case "date":
            case "datetime":
            case "updated":
                $sqlCode .= " `".$field["name"]."` DATETIME NULL ";
                $tableIndexes[] = $field["name"];
                break;

            default:
                break;
        }
        $sqlCode .= ",\n";
    }
    $sqlCode .= " PRIMARY KEY (`id`)) ";


    // add table index to SQL indexes

    if (strpos($infoTable["index"], ",") !== false) {
        // multi index

        // TODO: DO HERE
    } else {
        // single index
        if (!in_array($infoTable["index"], $tableIndexes)) {
            $tableIndexes[] = $infoTable["index"];
        }
    }

    $result = db_sql($sqlCode);
    if ($result["ok"]) {
        foreach ($tableIndexes as $field) {
            db_sql("ALTER TABLE `$table` ADD INDEX `$field` (`$field` ASC)");
        }
    }

    return $result;
}

/**
 * Add data to database
 *
 * @param string $table Table name in database
 * @param array $fields Associative array with data
 * @param string $lang LANG of data, support ALL
 * @return array API result of action
 */
function db_add($table, $fields, $lang = LANG) {

    // run recursively and exit
    if ($lang === "all") {

        $website = msv_get("website");

        foreach ($website->languages as $langID) {
            db_add($table, $fields, $langID);
        }

        return true;
    }

    $tablesList = msv_get("website.tables");
    $infoTable = $tablesList[$table];
    $filter = "";

    // check for dublicate
    $tableIndex = $infoTable["index"];
    if (strpos($tableIndex, ",") !== false) {
        $arIndex = explode(",", $tableIndex);

        foreach ($arIndex as $index) {
            $filter .= "`$index` = '".$fields[$index]."' and ";
        }
        $filter = substr($filter, 0, -4);
    } else {
        $filter = $infoTable['index']." = '".$fields[$infoTable['index']]."'";
    }

    // get count
    $resultQuery = db_get_count($table, $filter, $lang);
    if ($resultQuery["data"] > 0) {
        // no need to add, item already exists

        $result = array(
            "ok" => false,
            "data" => array(),
            "msg" => "Already exists",
        );
        return $result;
    }

    $tablesList = msv_get("website.tables");
    $infoTable = $tablesList[$table];

    $fields["deleted"] = 0;
    if (empty($fields["author"])) {
        $fields["author"] = "api";

        if (!empty($_SESSION["user_email"])) {
            $fields["author"] = $_SESSION["user_email"];
        }
    }

    $fields["lang"] = $lang;
    $fields["updated"] = date("Y-m-d H:i:s");

    $sqlCode = "insert into `$table` ( ";

    foreach ($infoTable["fields"] as $field) {
        // TODO: ??? do we need to skip fields that are missing in $field
        ///if (!array_key_exists($field["name"], $fields)) continue;

        // skip ID
        if ($field["type"] === "id") {
            continue;
        }

        $sqlCode .= " `".$field["name"]."`,";
    }
    $sqlCode = substr($sqlCode, 0, -1)." ) ";
    $sqlCode .= " values (";
    $indexValue = '';

    foreach ($infoTable["fields"] as $field) {
        //TODO: ???? if (!array_key_exists($field["name"], $fields)) continue;

        // skip ID
        // store ID value to use it as default for url
        if ($field["type"] === "id") {
            $indexValue = $fields[$field["name"]];
            continue;
        }
        if (array_key_exists($field["name"], $fields)) {
            $value = $fields[$field["name"]];
        } else {
            $value = "";
        }

        switch ($field["type"]) {
            case "published":
            case "deleted":
            case "bool":
            case "int":
                $valueEscaped = " '".(int)$value."' ";
                break;
            case "updated":
                $valueEscaped = " now() ";
                break;
            case "multiselect":
            case "array":
                $valueEscaped = " '".db_escape(serialize($value))."' ";
                break;
            case "pic":
                $valueEscaped = " '".db_escape($value)."' ";
                break;
            case "url":
                // if url is empty set: url = id
                if (empty($value) && empty($indexValue)) {
                    $valueEscaped = " '----------' ";
                } elseif (empty($value)) {
                    $valueEscaped = " '".db_escape($indexValue)."' ";
                } else {
                    $valueEscaped = " '".db_escape($value)."' ";
                }
                break;
            case "date":
            case "datetime":
                if (is_numeric($value)) {
                    $valueEscaped = "'".date("Y-m-d H:i:s", $value)."'";
                } elseif (!empty($value)) {
                    $valueEscaped = " '".db_escape($value)."' ";
                } else {
                    $valueEscaped = " now() ";
                }
                break;
            default:
                $valueEscaped = " '".db_escape($value)."' ";
                break;
        }

        $sqlCode .= " ".$valueEscaped.",";
    }

    $sqlCode = substr($sqlCode, 0, -1)." ) ";

    $result = db_sql($sqlCode);

    if (!empty($result["insert_id"])) {
        $fields["id"] = $result["insert_id"];
        $result["data"] = $fields;
    }

    return $result;
}

/**
 * get value of next auto increment ID
 *
 * @param string $table Table name in database
 * @return int Auto_increment. ID of a next row in DB
 */
function db_get_autoincrement($table) {
    $sql = "SHOW TABLE STATUS FROM `".DB_NAME."` LIKE '$table'";

    $result = db_sql($sql);
    $resultRow = db_fetch_row($result["data"]);

    return $resultRow['Auto_increment'];
}
