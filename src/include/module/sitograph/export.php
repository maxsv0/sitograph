<?php
if (empty($section)) {
    msv_error("Wrong input for export");
}

// full website export
if (isset($_REQUEST["full"])) {
    $fileName = "sitograph-".date("dmYHi").".zip";
    $filePath = sys_get_temp_dir()."/".$fileName;

    // create archive
    if (!file_exists($filePath)) {
        shell_exec("find ".ABS." -path '*/.*' -prune -o -type f -print | zip $filePath -@");
    }

    header('Content-Encoding: UTF-8');
    header('Content-type: application/zip; charset=UTF-8');
    header('Content-Disposition: attachment; filename='.$fileName);

    echo file_get_contents($filePath);
    die;
}

$table = $_REQUEST["table"];
$module = $_REQUEST["module"];

if (empty($table) && empty($module)) {
    msv_error("Wrong input for export");
}

if (!empty($table)) {
    if (!empty($_REQUEST["sort"])) {
        // TODO: check if correct key
        $sort = $_REQUEST["sort"];
    } else {
        $sort = "id";
    }

    if (!empty($_REQUEST["sortd"])) {
        if ($_REQUEST["sortd"] === "desc") {
            $sortd = "desc";
            $sortd_rev = "asc";
        } else {
            $sortd = "asc";
            $sortd_rev = "desc";
        }
    } else {
        $sortd = "desc";
        $sortd_rev = "asc";
    }

    if (!empty($_REQUEST["p"]) && !empty($_REQUEST["pn"])) {
        $listLimit = (int)$_REQUEST["pn"];
    } else {
        $listLimit = 65000;
    }

    $tableInfo = msv_get_config_table($table);

    if (empty($tableInfo)) {
        msv_message_error("Table not found '$table'");
        return false;
    }

    $resultQuery = db_get_listpaged($table, "", "`$sort` $sortd", $listLimit, "p");
    if ($resultQuery["ok"]) {
        $skipFields = array();
        $skipFields[] = "deleted";
        $skipFields[] = "published";
        $skipFields[] = "author";
        $skipFields[] = "updated";

        foreach ($tableInfo["fields"] as $field) {
            if($field["listskip"] > 0) {
                $skipFields[] = $field["name"];
            }
        }
        // in case of full export don't skip any fields
        if (isset($_GET["export_full"])) {
            $skipFields = array();
        }

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename='.$table.'-'.time().'.csv');

        $out = fopen('php://output', 'w');
        fputs($out, "\xEF\xBB\xBF");

        $rowShort = array();
        foreach ($tableInfo["fields"] as $field) {
            if (!in_array($field["name"], $skipFields)) {
                $rowShort[] = _t("table.".$tableInfo["name"].".".$field["name"]);
            }
        }
        fputcsv($out, $rowShort);

        foreach ($resultQuery["data"] as $row) {
            $rowShort = array();

            foreach ($row as $k => $v) {
                if (!in_array($k, $skipFields)) {
                    $rowShort[] = $v;
                }
            }
            fputcsv($out, $rowShort);
        }

        fclose($out);
        die;
    } else {
        msv_message_error($resultQuery["msg"]);
        return false;
    }
}

if (!empty($module)) {
    $moduleObj = msv_get("website.".$module);

    var_dump($moduleObj->files);
    die("123");

}

msv_error("Wrong input for export");