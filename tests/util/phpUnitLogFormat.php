<?php

$logFile = $argv[1];
$reportFile = $argv[2];

if (empty($logFile)) die();
if (empty($reportFile)) die();

$cont = file_get_contents($logFile);
echo "File found: $logFile ".strlen($cont)." bytes\n";

$a = strpos($cont, "</header>");
$cont = substr($cont, $a+9);

$a = strpos($cont, "<footer>");
$cont = substr($cont, 0, $a);

$cont = $cont."</div>";

$cont = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $cont);
$cont = preg_replace('#<span.*?>(.*?)</span>#i', '', $cont);

$tr_list = explode("<tr>", $cont);
echo count($tr_list)." lines found\n";

$cont_filtered = "";
$i = 0;
foreach ($tr_list as $block) {
    // skip title
    if (strpos($block, "Code Coverage") !== false) continue;

    if (strpos($block, ">Total<") !== false) {
        $tr_text = "<tr class='lead'>";
    } else {
        $tr_text = "<tr>";
    }
    if ($i++>0) {
        $cont_filtered .= $tr_text;
    }

    $td_list = explode("<td", $block);

    if (count($td_list) === 5) {
    	unset($td_list[4]);
	} elseif (count($td_list) === 11) {
    	unset($td_list[8]);
    	unset($td_list[9]);
    	unset($td_list[10]);
	}
	$block = implode("<td", $td_list);

    $cont_filtered .= $block;
}

echo "Write to file $reportFile ".strlen($cont_filtered)." bytes\n";

file_put_contents($reportFile, $cont_filtered);
