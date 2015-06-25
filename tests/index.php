<?php

// Add phpunit tests

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../vendor/autoload.php';

$config = new MASNathan\Config\Config();
$config->load('configs/*.yml');

echo '<pre>';
var_dump($config);
