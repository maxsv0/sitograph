<?php

function msv_seo_setseo($seo) {
	$result = db_get(TABLE_SEO, " `url` = '".$seo->website->requestUrlRaw."' ");
	if (!$result["ok"]) {
	    msv_message_error($result["msg"]);
	}
	$row = $result["data"];
	if (empty($row)) return false;

	return SEO_set($row["title"], $row["keywords"], $row["description"]);
}


function msv_seo_setlead($seo) {

    $user = msv_get("website.user");
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $sid = session_id();
    $ip = msv_get_ip();

    if (empty($_SESSION["lead_id"])) {

        $result = db_get(TABLE_LEADS, "( 
											`user_id` = '".(int)$user["id"]."' and
											`ip` = '".db_escape($ip)."'  and 
											`ua` = '".db_escape($ua)."' 
										) or
											`phpid` = '".db_escape($sid)."'
										");
        if ($result["ok"] && !empty($result["data"])) {
            $lead = $result["data"];
            $_SESSION["lead_id"] = $lead["id"];

            db_update(TABLE_LEADS, "last_action", "now()", " `id` = '".$lead["id"]."'");
            if ($lead["phpid"] != $sid) {
                db_update(TABLE_LEADS, "phpid", "'".db_escape($sid)."'", " `id` = '".$lead["id"]."'");
            }
            if ($lead["user_id"] != $user["id"]) {
                db_update(TABLE_LEADS, "user_id", "'".(int)$user["id"]."'", " `id` = '".$lead["id"]."'");
            }
            if ($lead["ip"] != $ip) {
                db_update(TABLE_LEADS, "ip", "'".db_escape($ip)."'", " `id` = '".$lead["id"]."'");
            }
        } else {

            // gen new lead

            $leadItem = array(
                "published" => 1,
                "user_id" => (int)$user["id"],
                "ip" => msv_get_ip(),
                "country" => '',
                "ua" => $ua,
                "referrer" => $_SERVER['HTTP_REFERER'],
                "phpid" => $sid,
            );
            $result = db_add(TABLE_LEADS, $leadItem);
            $_SESSION["lead_id"] = $result["insert_id"];

        }
    } else {
        $result = db_get(TABLE_LEADS, " `id` = '".(int)$_SESSION["lead_id"]."'");
        if ($result["ok"] && !empty($result["data"])) {
            // check if nothing changed
            $lead = $result["data"];

            db_update(TABLE_LEADS, "last_action", "now()", " `id` = '".$lead["id"]."'");
            if ($lead["phpid"] != $sid) {
                db_update(TABLE_LEADS, "phpid", "'".db_escape($sid)."'", " `id` = '".$lead["id"]."'");
            }
            if ($lead["user_id"] != $user["id"]) {
                db_update(TABLE_LEADS, "user_id", "'".(int)$user["id"]."'", " `id` = '".$lead["id"]."'");
            }
            if ($lead["ip"] != $ip) {
                db_update(TABLE_LEADS, "ip", "'".db_escape($ip)."'", " `id` = '".$lead["id"]."'");
            }
        } else {
            // gen new lead2

            $leadItem = array(
                "published" => 1,
                "user_id" => (int)$user["id"],
                "ip" => $ip,
                "country" => '',
                "ua" => $ua,
                "referrer" => $_SERVER['HTTP_REFERER'],
                "phpid" => $sid,
            );
            $result = db_add(TABLE_LEADS, $leadItem);
            $_SESSION["lead_id"] = $result["insert_id"];

        }
    }


}

function msv_seo_showleads($seo) {
    if ($_REQUEST["range"] === "7d") {
        $filter = "`last_action` > NOW() - INTERVAL 7 DAY";
    } elseif ($_REQUEST["range"] === "30d") {
        $filter = "`last_action` > NOW() - INTERVAL 30 DAY";
    } else {
        $filter = "`last_action` > NOW() - INTERVAL 1 DAY";
    }
    $result = db_get_list(TABLE_LEADS, $filter, "`last_action` desc");
    $list = $result["data"];

    $listLeads = array();

    foreach ($list as $lead) {
        $tm = strtotime($lead["last_action"]);
        if (time() - $tm < 60*5) {
            $lead["status"] = "online";
        } else {
            $lead["status"] = "offline";
        }

        $lead["ua_info"] = unserialize($lead["ua_info"]);

        if ($_REQUEST["section"] === "leads") {
            load_seo_lead_uainfo($lead);
            load_seo_lead_ipinfo($lead);
        }

        $listLeads[] = $lead;
    }

    msv_assign_data("lead_list", $listLeads);
}

function load_seo_lead_ipinfo($lead) {
    if (empty($lead["id"])) return false;

    if (!empty($lead["ip"]) && empty($lead["ip_info"])) {

        $execIP = msv_get_config("service_ip_info");
        if (!empty($execIP)) {
            $execIP = str_replace("{ip}", $lead["ip"], $execIP);
            $cont = trim(shell_exec($execIP));

            if (!empty($cont)) {
                $result = json_decode($cont, true);
            } else {
                $result = array();
            }

            db_update(TABLE_LEADS, "ip_info", "'".db_escape(serialize($result))."'", " `id` = '".$lead["id"]."'");

            $lead["ua_info"] = $result;
        }
    }
}

function load_seo_lead_uainfo($lead) {
    if (empty($lead["id"])) return false;

    if (!empty($lead["ua"]) && empty($lead["ua_info"])) {

        $execUA = msv_get_config("service_ua_info");
        if (!empty($execUA)) {
            $execUA = str_replace("{ua}", $lead["ua"], $execUA);
            $cont = trim(shell_exec($execUA));

            if (!empty($cont)) {
                $result = json_decode($cont, true);
            } else {
                $result = array();
            }

            db_update(TABLE_LEADS, "ua_info", "'".db_escape(serialize($result))."'", " `id` = '".$lead["id"]."'");

            $lead["ua_info"] = $result;
        }
    }
}

function SEO_set($title = "", $description = "", $keywords = "") {
    msv_log("Module:SEO -> Set: $title");
	
	$website = msv_get("website");
	
	$website->page["title"] = $title;
	$website->page["keywords"] = $description;
	$website->page["description"] = $keywords;
	
	return true;
}


		
		
		