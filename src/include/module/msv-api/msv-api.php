<?php
function apiRequest($module) {
	$apiRequest = $module->website->requestUrlMatch[1];
	
	foreach ($module->website->api as $apiInfo) {
		if ($apiInfo["name"] === $apiRequest) {
			if (function_exists($apiInfo["action"])) {
				$evalCode = "\$result = ".$apiInfo["action"]."(\$module);";
				eval($evalCode);
				
				echo $result;
			} else {
				MSV_Error("Function not found: ".$apiInfo["action"]);
			}
		}
	}
	
	die;
}


// ============ add functions ==========  

function API_SQL($sqlCode) {
	// function returns $result
	$result = array(
		"ok" => true,
		"data" => array(),
		"msg" => "",
	);
	
	MSV_Log("SQL: $sqlCode", "debug");

	$website = MSV_get("website");

	// exit if DB connection doest not exist
	if (!$website->config["db"]) {
		$result["ok"] = false;
		$result["msg"] = "DB connection is not active.";
		return $result;
	}
	$query = mysqli_query($website->config["db"], $sqlCode);
	
	$result["data"] = $query;

	if ($query) {
		
		$result["insert_id"] = mysqli_insert_id($website->config["db"]);
		
	} else {
		$result["ok"] = false;
		$result["msg"] = mysqli_error($website->config["db"]);
			
		if (DEBUG) {
			$str = "*** ERROR: ".$result["msg"];
			MSV_Log($str, "debug");
		}
	}

	$result["sql"] = $sqlCode;
	return $result;
}



function API_call($param) {
	
	
	//TODO: ....
	
}



function API_callError($msg) {
	// todo: log error
	// notify admin
	// show error in template	
	
	
	MSV_MessageError($msg);
}

function API_setData() {
	
}



function API_getConfig($param) {
	// function returns $result
	$result = array(
		"ok" => true,
		"data" => array(),
		"msg" => "",
	);
	
	$website = MSV_get("website");
	
	// TODO: check
	if (array_key_exists($param, $website->config)) {
		$value = $website->config[$param];
		$result["data"] = $value;
	} else {
		$result["ok"] = false;
	}
	
	return $result;
}






function API_updateDBItemRow($table, $row) {
	// function returns $result
	$result = array(
		"ok" => true,
		"data" => array(),
		"msg" => "",
	);
	
	// get list of tables and check $table
	$tablesList = MSV_get("website.tables");
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
			} else {
				$value = $indexValue;
			}
		}
		
		if ($type === "bool"		 ||
			$type === "int" 		 ||
			$type === "select" 		 ||
			$type === "published" 	 ||
			$type === "deleted" 	 ||
			$type === "int"
			) {
			$sqlCodeValue .= "".(int)$value.",";
			$sqlCodeUpdate .= " `".$field."` = ".(int)$value.", ";
		} else {
			$sqlCodeValue .= "'".MSV_SQLEscape($value)."',";
			$sqlCodeUpdate .= " `".$field."` = '".MSV_SQLEscape($value)."', ";
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

	MSV_Log("API_updateDBItemRow for table $table");

	return API_SQL($sqlCode);
}

function API_updateDBItem($table, $param, $value, $filter = "", $lang = LANG) {
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
	$sqlCode .= " `published` > 0 and ";
	$sqlCode .= " (`lang` = '".$lang."' or `lang` = '*') ";
	if (!empty($filter)) {
		$sqlCode .= " and ";
		$sqlCode .= $filter;
	} 
	
	MSV_Log("API_updateDBItem for table $table, $param, $value, $filter");
	
	return API_SQL($sqlCode);
}


function API_deleteDBItem($table, $filter = "") {
	
	return API_updateDBItem($table, "deleted", 1, $filter);
}



function API_getDBListPaged($table, $filter = "", $orderby = "", $items_per_page = 10, $page_url_param = "p") {
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
	
	$resultCount = API_getDBCount($table, $filter);
	if (!$resultCount["ok"]) {
		return $resultCount;
	}
	$num_rows = $resultCount["data"];
	if ($num_rows === 0) {
		return $result;
	}
	
	
	$resultList = API_getDBList($table, $filter, $orderby, $items_per_page, $skip);
	if (!$resultList["ok"]) {
		return $resultList;
	}
	

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



function API_getDBItem($table, $filter = "", $lang = LANG) {
	// function returns $result
	$result = array(
		"ok" => true,
		"data" => array(),
		"msg" => "",
	);
	
	// TODO: clear input: (int), mysql_real_escape_string
	// TODO: check if $table in conf.
	
	$sqlCode = "select * from `$table` where ";

	$user = MSV_get("website.user");
	if (!($user["access"] === "superadmin" || $user["access"] === "admin")) {
		$sqlCode .= " `published` > 0 and ";
	}
	
	$sqlCode .= " `deleted` = 0 and  ";
	$sqlCode .= " (`lang` = '".$lang."' or `lang` = '*') ";
	
	if (!empty($filter)) {
		$sqlCode .= " and ";
		$sqlCode .= $filter;
	} 
	
	$resultQuery = API_SQL($sqlCode);
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
	
	$resultRow = MSV_SQLRow($resultQuery["data"]);
	if (!$resultRow) {
		$result["ok"] = false;
		$result["msg"] = _t("msg.cant_get_table_data")." `$table`";
		return $result;
	}
	
	$rowFormated = MSV_DataFormat($table, $resultRow);
	
	$result["data"] = $rowFormated;
	
	return $result;
}




function API_getDBCount($table, $filter, $lang = LANG) {
	// function returns $result
	$result = array(
		"ok" => true,
		"data" => array(),
		"msg" => "",
	);
	
	$sqlCode = "select count(*) total from `$table` where";

	$user = MSV_get("website.user");
	if (!($user["access"] === "superadmin" || $user["access"] === "admin")) {
		$sqlCode .= " `published` > 0 and ";
	}
	
	$sqlCode .= " `deleted` = 0  and ";
	$sqlCode .= " (`lang` = '".$lang."' or `lang` = '*')  ";
	if (!empty($filter)) {
		$sqlCode .= " and ";
		$sqlCode .= $filter;
	} 
	
	$resultQuery = API_SQL($sqlCode);
	if (!$resultQuery["ok"]) {
		$result["ok"] = false;
		$result["msg"] = "Can't get table count `$table`";
		return $result;
	}
	$row = mysqli_fetch_assoc($resultQuery["data"]);
	$result["data"] = (int)$row["total"];
	
	return $result;
}


function API_getDBList($table, $filter = "", $orderby = "", $limit = 1000000, $skip = 0, $lang = LANG) {
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
	
	$tablesList = MSV_get("website.tables");
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
	
	$user = MSV_get("website.user");
	if (!($user["access"] === "superadmin" || $user["access"] === "admin")) {
		$sqlCode .= " `published` > 0 and ";
	}
	
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
	
	$resultQuery = API_SQL($sqlCode);
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
	while ($resultRow = MSV_SQLRow($resultQuery["data"])) {
		// format row
		$rowFormated = MSV_DataFormat($table, $resultRow);
		
		// add formated row to list
		$listItem[$rowFormated["id"]] = $rowFormated;
	}
	$result["data"] = $listItem;
	
	return $result;
}

function API_setStructure($row) {
	$website = MSV_get("website");
	
	// TODO : CHECK ... 
	$website->structure[] = $row;
}
function API_setMenu($menuID, $row) {
	$website = MSV_get("website");
	
	// TODO : CHECK input 
	
	// parse sub-level structure, based on parent_id
	$menu = array();
	
	// build 0 level menu
	foreach ($row as $item) {
		if ($item["parent_id"] > 0) continue;
		$menu[$item["id"]] = $item;
	}
	
	// build first level submenu
	foreach ($row as $itemSub) {
		if ($itemSub["parent_id"] > 0) {
			$menu[$itemSub["parent_id"]]["sub"][$itemSub["id"]] = $itemSub;
		}
	}
	
	$website->menu[$menuID] = array_values($menu);
}


function API_removeTable($table) {
	$tablesList = MSV_get("website.tables");
	$infoTable = $tablesList[$table];
	if (empty($infoTable)) {
		return false;
	}
	
	$sqlCode = "DROP TABLE `$table`";
	
	$result = API_SQL($sqlCode);
	
	return $result;
}



function API_emptyTable($table) {
	$tablesList = MSV_get("website.tables");
	$infoTable = $tablesList[$table];
	if (empty($infoTable)) {
		return false;
	}

	$sqlCode = "TRUNCATE TABLE `$table`";

	$result = API_SQL($sqlCode);

	return $result;
}


function API_createTable($table) {
	$tablesList = MSV_get("website.tables");
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
	
	

	$result = API_SQL($sqlCode);
	if ($result["ok"]) {
		foreach ($tableIndexes as $field) {
			API_SQL("ALTER TABLE `$table` ADD INDEX `$field` (`$field` ASC)");
		}
	}
	
	return $result;
}


function API_itemAdd($table, $fields, $lang = LANG) {
	
	// run recursively and exit
	if ($lang === "all") {
		
		$website = MSV_get("website");

		foreach ($website->languages as $langID) {
			API_itemAdd($table, $fields, $langID);
		}
		
		return true;
	}
	
	
	
	
	$tablesList = MSV_get("website.tables");
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
	$resultQuery = API_getDBCount($table, $filter, $lang);
	if ($resultQuery["data"] > 0) {
		// no need to add, item already exists
		
		$result = array(
			"ok" => false,
			"data" => array(),
			"msg" => "Already exists",
		);
		return $result;
	}
	
	$tablesList = MSV_get("website.tables");
	$infoTable = $tablesList[$table];
	
	$fields["deleted"] = 0;
	$fields["author"] = "api";
	if (!empty($_SESSION["user_email"])) {
		$fields["author"] = $_SESSION["user_email"];
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
				$valueEscaped = " '".MSV_SQLEscape(serialize($value))."' ";
			break;
			case "pic":
				$valueEscaped = " '".MSV_SQLEscape($value)."' ";
			break;
			case "url":
				// if url is empty set: url = id
				if (empty($value) && empty($indexValue)) {
					$valueEscaped = " '----------' ";
				} elseif (empty($value)) {
					$valueEscaped = " '".MSV_SQLEscape($indexValue)."' ";
				} else {
					$valueEscaped = " '".MSV_SQLEscape($value)."' ";
				}
			break;
            case "date":
            case "datetime":
                if (is_numeric($value)) {
                    $valueEscaped = "'".date("Y-m-d H:i:s", $value)."'";
                } elseif (!empty($value)) {
                    $valueEscaped = " '".MSV_SQLEscape($value)."' ";
                } else {
                    $valueEscaped = " '0000-00-00 00:00:00' ";
                }
                break;
			default:
				$valueEscaped = " '".MSV_SQLEscape($value)."' ";
			break;
		}
		
		$sqlCode .= " ".$valueEscaped.",";
	}
	
	$sqlCode = substr($sqlCode, 0, -1)." ) ";
	
	return API_SQL($sqlCode);
}
