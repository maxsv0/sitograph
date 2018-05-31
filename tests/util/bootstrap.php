<?php
error_reporting(E_ALL);

include("MSVTestCase.php");
include("BlogUtil.php");

// Mock some default
if (empty($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = "testlocalhost";
}
if (empty($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = "testreferer";
}
if (empty($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = "/";
}

// Load MSV Website
require(__DIR__."/./../../src/load.php");

ini_set("display_errors", 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// create MSV Website instance
$website = new MSV_Website();

// start the instance
$website->start();
