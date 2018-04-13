<?php
error_reporting(E_ALL);

// run CMS
chdir(__DIR__."./../../src/");

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
include("load.php");