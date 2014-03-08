<?php

namespace MASNathan\Config;

/**
 * Config - Configuration files reader/ loader
 * 
 * @author André Filipe <andre.r.flip@gmail.com>
 * @link https://github.com/ReiDuKuduro/Config4all Github Repo
 * @link http://masnathan.users.phpclasses.org/package/8111 PHP Classes
 * @license	MIT
 * @version 2.0.0
 */
class Config {
	use Parser;

	/**
	 * Configs are stored here
	 * @var array
	 */
	protected $data = [];
	
	/**
	 * Loads the configs on the desired files
	 * @param args Files to load
	 * @throws Exception When the supposed file path is not a string
	 * @throws Exception If the file doesn't exist
	 */
	public function load()
	{
		$data =  func_get_args();
		$files = array();
		foreach ($data as $value )
		{
			if ( !is_string( $value ) )
				throw new Exception( "Invalid parameter passed on Config4all -> load function. All parameters must be string!" );
			
			$files = array_merge( $files, glob( $value ) );
		}
		
		foreach ($files as $filepath) {
			$filename = pathinfo($filepath, PATHINFO_FILENAME);

			$this->data[$filename] = $this->getFileContents($filepath);
		}
		
		return $this;
	}
	
	/**
	 * Empty all the loaded configs
	 */
	public function clear()
	{
		$this->data = [];
	}
	
	/**
	 * Returns all configs if no param is passed, returns a specific config if it's name is defined
	 * @param args Used to find the desired position on the configs array
	 * @return array|string|null
	 */
	public function get()
	{
		$data =  func_get_args();
		if ( empty( $data ) )
			return $this->data;
		
		$tmp_config = $this->data;
		foreach ( $data as $config_position )
		{
			if ( isset( $tmp_config[ $config_position ] ) )
				$tmp_config = $tmp_config[ $config_position ];
			else
				return null;
		}
		
		return $tmp_config;
	}
	
	/**
	 * Sets a new config
	 * @param args Used to set the desired position on the configs array and it's value, the last argument will be the value to set
	 * @throws Exception If no parameter is passed
	 * @return obj
	 */
	public function set()
	{
		$data 	=  func_get_args();
		$value 	= null;
		
		if ( empty( $data ) )
			throw new Exception( "Missing argument!" );
		
		if ( count( $data ) > 1 )
			$value = array_pop( $data );
		
		$data 	= array_reverse( $data );
		$tmp 	= array();
		
		foreach ( $data as $new_position ) {
			if ( empty( $tmp ) )
				$tmp = array( $new_position => $value );
			else
				$tmp = array( $new_position => $tmp );
		}
		
		//Merging the arrays
		$this->data = array_replace_recursive( $this->data, $tmp );
		
		return $this;
	}
}
