<?php

namespace MASNathan\Config;

use MASNathan\Config\Exception\FileNotFound;
use MASNathan\Config\Exception\UnsupportedFileType;
use MASNathan\Config\Exception\UnsuportedByServer;
use MASNathan\Config\Exception\ParseError;
use Symfony\Component\Yaml\Yaml;

trait Parser
{

	protected function getFileContents($filepath)
	{
		$fileType = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
		switch ($fileType) {
			case 'php':
				return $this->getPhpContents($filepath);
			case 'ini':
				return $this->getIniContents($filepath);
			case 'json':
				return $this->getJsonContents($filepath);
			case 'yml':
			case 'yaml':
				return $this->getYmlContents($filepath);
			case 'xml':
				return $this->getXmlContents($filepath);
			
			default:
				throw new UnsupportedFileType($fileType);
		}
	}

	protected function getPhpContents($filepath)
	{
		if (!file_exists($filepath)) {
			throw new FileNotFound($filepath);
		}

		include $filepath;

		$definedVars = \get_defined_vars();
		//removing the filepath entry
		array_shift($definedVars);

		$parsedContents = \reset($definedVars);

		return $parsedContents;
	}	

	protected function getIniContents($filepath)
	{
		if (!file_exists($filepath)) {
			throw new FileNotFound($filepath);
		}

		if (!function_exists('parse_ini_file')) {
			throw new UnsuportedByServer('ini');
		}

		$parsedContents = \parse_ini_file($filepath, true);
		
		return $parsedContents;
	}

	/**
	 * Parses the contents from a JSON file
	 * @param string $filepath
	 * @return array
	 * @throws FileNotFound       The file to load does not exist
	 * @throws UnsuportedByServer Your server/machine does not have the json extension installed
	 * @throws ParseError         There was something wrong with the json file
	 */
	protected function getJsonContents($filepath)
	{
		if (!file_exists($filepath)) {
			throw new FileNotFound($filepath);
		}

		if (!function_exists('json_decode')) {
			throw new UnsuportedByServer('json');
		}

		$fileContents   = \file_get_contents($filepath);
		$parsedContents = \json_decode($fileContents, true);

		switch (\json_last_error()) {
			case JSON_ERROR_NONE:
				return $parsedContents;

	        case JSON_ERROR_DEPTH:
	            throw new ParseError("Maximum stack depth exceeded");
	        break;
	        case JSON_ERROR_STATE_MISMATCH:
	            throw new ParseError("Underflow or the modes mismatch");
	        break;
	        case JSON_ERROR_CTRL_CHAR:
	            throw new ParseError("Unexpected control character found");
	        break;
	        case JSON_ERROR_SYNTAX:
	            throw new ParseError("Syntax error, malformed JSON");
	        break;
	        case JSON_ERROR_UTF8:
	            throw new ParseError("Malformed UTF-8 characters, possibly incorrectly encoded");
	        break;
	        default:
	            throw new ParseError("Unknown error on JSON file");
	        break;
    	}
	}

	protected function getYmlContents($filepath)
	{
		if (!file_exists($filepath)) {
			throw new FileNotFound($filepath);
		}

		$parsedContents = Yaml::parse($filepath);

		return $parsedContents;
	}

	protected function getXmlContents($filepath)
	{
		if (!file_exists($filepath)) {
			throw new FileNotFound($filepath);
		}

		if (!function_exists('simplexml_load_file')) {
			throw new UnsuportedByServer('xml');
		}

		$xmlObject      = \simplexml_load_file($filepath);
		$jsonObject     = \json_encode((array) $xmlObject);
		$parsedContents = \json_decode($jsonObject, true);

		return $parsedContents;
	}
}