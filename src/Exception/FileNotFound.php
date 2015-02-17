<?php

namespace MASNathan\Config\Exception;

class FileNotFound extends \Exception
{
	public function __construct($filepath, $code = 0, $previous = null)
	{
	   	$message = sprintf("The file \"%s\" does not exist!", $filepath);
	   	
        parent::__construct($message, $code, $previous);
    }
}