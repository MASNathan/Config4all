<?php


require_once '../vendor/autoload.php';

$config = new MASNathan\Config\Config;

echo '<pre>';

/*
This is the data structure
[
	(string) filename1 => (array) contents,
	(string) filename2 => (array) contents
]
*/

/*
//example 1
$config->load('configs/config.php', 'configs/database.php');
//*/

/*
//example 2
//You can load file by file, or you can use this method to load all the files with a certain extension
$config->load('configs/*.php');
//*/


//example 3
//Works the same way with xml, json, ini and yml files ( yml files are not yet implemented )
$config->load('configs/*.php');
//*/

/*
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

$config -> load( 'configs/*.php' );

//Fetching data from configurations
echo '<br />Config username: ' . $config -> get( 'config', 'username' );
echo '<br />Database host: ' . $config -> get( 'database', 'host' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'potatoes' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'php', 'classes' );
echo '<br />Random stuff: ' . $config -> get( 'config', 'random_stuff', 'php', 'github' );

//Setting some new configurations, and changing some old ones
$config -> set( 'a', 'b', 'c', 'value' )
        -> set( 'config', 'username', 'Not Andre Filipe' )
        -> set( 'database', 'host', 'first', 'localhost' )
        -> set( 'database', 'host', 'second', 'somehost' )
        -> set( 'this is a null field' );

echo '<br />Config username: ' . $config -> get( 'config', 'username' );
echo '<br />Database host: ' . $config -> get( 'database', 'host', 'second' );

var_dump( 'example 8', $config -> get() );
//*/

var_dump($config->get());
