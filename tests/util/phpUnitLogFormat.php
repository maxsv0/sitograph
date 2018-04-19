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

file_put_contents($reportFile, $cont);
