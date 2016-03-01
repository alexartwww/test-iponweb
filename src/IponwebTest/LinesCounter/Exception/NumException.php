<?php
namespace IponwebTest\LinesCounter\Exception;

class NumException extends \Exception
{
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
