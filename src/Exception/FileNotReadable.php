<?php

namespace MASNathan\Config\Exception;

class FileNotReadable extends \Exception
{
    public function __construct($filepath, $code = 0, $previous = null)
    {
        $message = sprintf("The file \"%s\" is not readable!", $filepath);
        
        parent::__construct($message, $code, $previous);
    }
}
