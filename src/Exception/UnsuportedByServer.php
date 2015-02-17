<?php

namespace MASNathan\Config\Exception;

class UnsuportedByServer extends \Exception
{
	public function __construct($fileType, $code = 0, $previous = null)
	{
	   	$message = sprintf("You server does not support %s files parsing!", $fileType);
	   	
        parent::__construct($message, $code, $previous);
    }
}