<?php
//fix some time is missed up
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

define('URL', str_replace("index.php", "", (isset($_SERVER["https"]) ? "https": "http").'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
require_once("config/Config.php");
require_once("controllers/Router.php");

//lance la gestion du routage du site
new Router();