<?php


if (is_readable(DEBUG_LOG)) {
	$cont = file_get_contents(DEBUG_LOG);
	
	$list = explode("\n", $cont);
	$listActions = array();
	$action = array();
	$actionIndex = 0;
	
	$dataLoad = array(
		"modules" => "activateModules ->",
		"run_time" => "Run time: ",
		"page" => "loadPage ->",
	);
	$dataGroupLoad = array(
		"sql" => "SQL: ",
	);
	
	
	foreach ($list as $line) {
		if (strpos($line, "__construct") !== false) {
			$action = array();
			$date = strtotime(substr($line, 0, 27));
			$action["start"] = date(DATE_FORMAT, $date);
		}
		if (strpos($line, "__destruct") !== false) {
			$date = strtotime(substr($line, 0, 27));
			$action["end"] = date(DATE_FORMAT, $date);
			
			$action["modules"] = explode(",", $action["modules"]);
			$listActions[$action["start"]] = $action;
		}
		
		foreach ($dataLoad as $key => $exp) {
			if (strpos($line, $exp) !== false) {
				list(,$data) = explode($exp, $line);
				$action[$key] = trim($data);
			}
		}
		
		foreach ($dataGroupLoad as $key => $exp) {
			if (strpos($line, $exp) !== false) {
				list(,$data) = explode($exp, $line);
				$action[$key][] = trim($data);
			}
		}
		
	}

	arsort($listActions);

    msv_assign_data("debug_log_actions", $listActions);
}