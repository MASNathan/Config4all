<?php

require_once 'Config4all.class.php';

$config = Config4all::getInstance();
/*
//Loading a simple PHP config file, note that the $array on the PHP config file needs to have the same name of the file it self
var_dump( 'example 1', $config -> load( 'configs/config.php', 'configs/database.php' ) -> get() );
$config -> clear();

//You can load file by file, or you can use this method to load all the files with a certain extension
var_dump( 'example 2', $config -> load( 'configs/*.php' ) -> get() );
$config -> clear();

//Works the same way with xml, json, ini and yml files ( yml files are not yet implemented )
var_dump( 'example 3', $config -> load( 'configs/*.xml' ) -> get() );
$config -> clear();
var_dump( 'example 4', $config -> load( 'configs/*.json' ) -> get() );
$config -> clear();
var_dump( 'example 5', $config -> load( 'configs/*.ini' ) -> get() );
$config -> clear();
var_dump( 'example 6 - coming soon' );
//var_dump( 'example 6', $config -> load( 'configs/*.yml' ) -> get() );
//$config -> clear();

//you can also load multiple files, regardless of the extension
var_dump( 'example 7', $config -> load( 'configs/*.*' ) -> get() );
$config -> clear();

//*/

$config -> load( 'configs/*.php' );

//Fetching data from configurations
echo '<br />Config username: ' . $config -> get( 'config', 'username' );
echo '<br />Database host: ' . $config -> get( 'database', 'host' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'potatoes' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'php', 'classes' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'php', 'github' );

//Setting
