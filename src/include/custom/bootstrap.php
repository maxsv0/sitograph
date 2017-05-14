<?php
/*
 * Load and register Smarty Autoloader
 */
if (!class_exists('Smarty_Autoloader')) {
    require __DIR__ . '/Autoloader.php';
}
Smarty_Autoloader::register();


/*
 * Load and register Google Service
 */
if (!class_exists('Google_Client')) {
    require __DIR__ . '/Google/autoload.php';
}
