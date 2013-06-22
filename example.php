<?php

require_once 'Config4all.class.php';

$config = Config4all::getInstance();

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
var_dump( 'example 4', $config -> load( 'configs/*.json' ) -> get() );
$config -> clear();


//$config -> load( 'configs/*.xml' );
//$config -> load( 'configs/*.ini' );
//$config -> load( 'configs/*.json' );
//$config -> load( 'configs/*.yml' );

//$config -> load( 'configs/config.php', 'configs/database.php' );

