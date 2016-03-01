<?php
namespace IponwebTest\LinesCounter\Interfaces;

interface ILinesCounter
{
    public function increment($line);
    public function getCounter();
    public function getTop($num=null);
}
