<?php
namespace IponwebTest\LinesCounter;

use IponwebTest\LinesCounter\Interfaces\ILinesCounter;
use IponwebTest\LinesCounter\Exception\NumException;

class LinesCounter implements ILinesCounter
{
    protected $counter;

    public function __construct()
    {
        $this->counter = [];
    }

    public function increment($line)
    {
        if (isset($this->counter[$line])) {
            $this->counter[$line]++;
        } else {
            $this->counter[$line] = 1;
        }
    }

    public function getCounter()
    {
        return $this->counter;
    }

    public function getTop($num = null)
    {
        if ($num !== null) {
            $num = intval($num);
            if ($num > count($this->counter)) {
                throw new NumException('Counter does not have so mush lines!');
            }
            if ($num <= 0) {
                throw new NumException('Num must be positive integer!');
            }
        }
        arsort($this->counter);

        return ($num !== null) ? array_slice($this->counter, 0, $num) : $this->counter;
    }
}
