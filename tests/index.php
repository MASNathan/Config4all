<?php

// Add phpunit tests

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../vendor/autoload.php';

$config = new MASNathan\Config\Config();
$config->read('configs/*.xml');

//$config->write('configs/cache.json');

$config->set('extra.super.extra', 'test');
$config->set('config.extra', 'test');

//$config->save('asd');

dump($config->get());


dump($config);
