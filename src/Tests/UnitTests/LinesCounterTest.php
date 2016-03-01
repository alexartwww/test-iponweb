<?php
namespace Tests\UnitTests;

use IponwebTest\LinesCounter\LinesCounter;

class LinesCounterTest extends \PHPUnit_Framework_TestCase
{
    public function testLinesCounter()
    {
        $linesCounter = new LinesCounter();
        $linesCounter->increment('a');
        $linesCounter->increment('c');
        $linesCounter->increment('b');
        $linesCounter->increment('b');
        $linesCounter->increment('c');
        $linesCounter->increment('c');
        $linesCounter->increment('c');
        $result = $linesCounter->getTop(2);
        $this->assertEquals(2, count($result));
        $this->assertEquals(4, $result['c']);
        $this->assertEquals(2, $result['b']);
    }

    public function testNumException()
    {
        $this->expectException('IponwebTest\LinesCounter\Exception\NumException');
        $linesCounter = new LinesCounter();
        $linesCounter->increment('a');
        $linesCounter->increment('c');
        $linesCounter->increment('b');
        $linesCounter->increment('b');
        $linesCounter->increment('c');
        $linesCounter->increment('c');
        $linesCounter->increment('c');
        $result = $linesCounter->getTop(20);
    }
}