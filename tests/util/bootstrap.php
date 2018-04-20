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

// chmod for CMS home
chdir(__DIR__."/./../../src/");

// Load MSV Website
include("load.php");

// create MSV Website instance
$website = new MSV_Website();

// start the instance
$website->start();
