<?php
namespace IponwebTest\LineFilter\RTrimFilter;

use IponwebTest\LineFilter\Interfaces\ILineFilter;

class RTrimFilter implements ILineFilter
{
    public function filter($line)
    {
        $line = rtrim($line);
        return (!empty($line)) ? $line : false;
    }
}
