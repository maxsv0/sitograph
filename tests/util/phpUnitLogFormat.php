<?php

$logFile = $argv[1];
$reportFile = $argv[2];

if (empty($logFile)) die();
if (empty($reportFile)) die();

$cont = file_get_contents($logFile);

$a = strpos($cont, "</header>");
$cont = substr($cont, $a+9);

$a = strpos($cont, "<footer>");
$cont = substr($cont, 0, $a);

$cont = $cont."</div>";

$cont = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $cont);
$cont = preg_replace('#<span.*?>(.*?)</span>#i', '', $cont);

file_put_contents($reportFile, $cont);
