<?php

namespace MASNathan\Config;

use MASNathan\Config\Exception\FileNotFound;
use MASNathan\Config\Exception\FileNotReadable;
use MASNathan\Config\Exception\FileNotWritable;
use MASNathan\Config\Exception\UnsupportedFileType;
use MASNathan\Parser\Parser;

/**
 * Config - Configuration files reader/ loader
 *
 * @author André Filipe <andre.r.flip@gmail.com>
 * @link https://github.com/MASNathan/Config4all Github Repo
 * @link http://masnathan.users.phpclasses.org/package/8111 PHP Classes
 * @license MIT
 * @version 2.2.0
 */
class Config
{

    /**
     * Configs are stored here
     * @var array
     */
    protected $data = array();
    
    /**
     * This file contains all the filepaths pointing to the Config::$data values
     * @var array
     */
    protected $files = array();

    /**
     * Reads and parses data from a file, using the extension to determine the data type
     * @param  string $filePath File path
     * @return array
     */
    protected function readFileData($filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileNotFound($filePath);
        }

        if (!is_readable($filePath)) {
            throw new FileNotReadable($filePath);
        }

        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($fileType == 'php') {
            $result = array();
            $result = (array) include $filePath;
        } else {
            $result = Parser::file($filePath)->from($fileType)->toArray();
        }

        return $result;
    }

    /**
     * Parses and writes some array to a file, using the extension the select the data type
     * @param  string $filePath File path
     * @param  array  $data     Data to parse and write to file
     * @return boolean
     */
    protected function writeFileData($filePath, array $data)
    {
        // @todo Check if files exists and create it
        /*
        if (!is_writable($filePath)) {
            throw new FileNotWritable($filePath);
        }
        //*/

        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($fileType == 'php') {
            // @todo Generate the php code
        } else {
            $contents = Parser::data($data)->setPrettyOutput(true)->to($fileType);
        }

        return file_put_contents($filePath, $contents);
    }


    /**
     * Loads the configs on the desired files
     * @param args Files to load
     * @throws Exception When the supposed file path is not a string
     * @throws Exception If the file doesn't exist
     */
    public function read()
    {
        $data  = func_get_args();
        $files = array();
        foreach ($data as $value) {
            if (!is_string($value)) {
                throw new \Exception("Invalid parameter passed on Config4all -> load function. All parameters must be string!");
            }
            
            $files = array_merge($files, glob($value));
        }

        foreach ($files as $filePath) {
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            switch ($fileType) {
                case 'xml':
                    $result = $this->readFileData($filePath);
                    // We need to get the root key so on write we have the xml root key name
                    $resultKeys = array_keys($result);
                    $rootKey = reset($resultKeys);
                    
                    $this->data[$fileName] = reset($result);
                    $this->files[$filePath] = array($rootKey => &$this->data[$fileName]);
                    break;
                
                case 'php':
                case 'ini':
                case 'yml':
                case 'yaml':
                case 'neon':
                    $result = $this->readFileData($filePath);
                    $this->data[$fileName] = $result;
                    $this->files[$filePath] = &$this->data[$fileName];
                    break;

                default:
                    throw new UnsupportedFileType($fileType);
            }
        }
        
        return $this;
    }

    /**
     * Writes all the configurations and it's changes to it's respective files
     * @return null
     */
    public function write()
    {
        foreach ($this->files as $filePath => $data) {
            // @todo Check for errors
            $this->writeFileData($filePath, $data);
        }
    }
    
    /**
     * Loads a single file into the configurations array
     * @param  string $filePath File path
     * @return Config
     */
    public function load($filePath)
    {
        $this->data = $this->readFileData($filePath);
        return $this;
    }

    /**
     * Saves all the configs into a single file
     * @param  string $filePath File path
     * @return boolean
     */
    public function save($filePath)
    {
        return $this->writeFileData($filePath, $this->data);
    }

    /**
     * Empty all the loaded configs
     * @return Config
     */
    public function clear()
    {
        $this->data = array();
        return $this;
    }
    
    /**
     * Returns all configs if no param is passed, returns a specific config if it's name is defined
     * @param args Used to find the desired position on the configs array
     * @return array|string|null
     */
    public function get()
    {
        $data = func_get_args();
        // if no argument is used we return the full config array
        if (empty($data)) {
            return $this->data;
        }

        // if there is only 1 argument and it's something like that: some_key.child_key.value
        // will be used as 3 arguments: "some_key", "child_key" and "value"
        if (count($data) == 1 && strpos($data[0], '.') !== false) {
            $data = explode('.', $data[0]);
        }
        
        $temporaryConfig = $this->data;
        foreach ($data as $config_position) {
            if (isset($temporaryConfig[$config_position])) {
                $temporaryConfig = $temporaryConfig[$config_position];
            } else {
                return null;
            }
        }
        
        return $temporaryConfig;
    }
    
    /**
     * Sets a new config
     * @param args Used to set the desired position on the configs array and it's value, the last argument will be the value to set
     * @return Config
     * @throws \Exception If no parameter is passed
     */
    public function set()
    {
        $data  = func_get_args();
        $value = null;
        
        if (empty($data)) {
            throw new \Exception("Missing argument!");
        }
        
        if (count($data) > 1) {
            $value = array_pop($data);
        }

        // if there is only 1 argument and contains dots, we'll split it
        if (count($data) == 1 && strpos($data[0], '.') !== false) {
            $data = explode('.', $data[0]);
        }
        
        $pointerArray = &$this->data;
        // Now we edit the array $data using a pointer
        foreach ($data as $arrayKey) {
            if (!isset($pointerArray[$arrayKey])) {
                $pointerArray[$arrayKey] = null;
            }
            $pointerArray = &$pointerArray[$arrayKey];
        }
        $pointerArray = $value;

        return $this;
    }
}
