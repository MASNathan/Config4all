<?php

namespace MASNathan\Config\Exception;

class UnsupportedFileType extends \Exception
{
	public function __construct($fileType, $code = 0, $previous = null)
	{
	   	$message = sprintf("This library does not support %s files!", $fileType);
	   	
        parent::__construct($message, $code, $previous);
    }
}