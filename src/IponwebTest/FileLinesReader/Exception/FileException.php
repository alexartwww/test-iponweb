<?php
namespace IponwebTest\FileLinesReader\Exception;

class FileException extends \Exception
{
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
