<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

define('ROOT', dirname(__FILE__).'/');
define('IDEAL', dirname(__FILE__).'/ideal/');
define('APP', dirname(__FILE__).'/application/');
include IDEAL.'framework.php';
include IDEAL.'functions.php';
require_once 'vendor/autoload.php';

App::gi()->start();
