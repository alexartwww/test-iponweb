<?php
namespace Tests\UnitTests;

use IponwebTest\FileLinesReader\FileLinesCounter;
use IponwebTest\LinesCounter\LinesCounter;
use IponwebTest\LineFilter\RTrimFilter\RTrimFilter;

class FileLinesCounterTest  extends \PHPUnit_Framework_TestCase
{
    const TEST_FILENAME='/tmp/FileLinesCounterTest.txt';

    public function createTestFile()
    {
        $lines = <<<END
a
c
b
b
c

c
c

END;
        $fileDescriptor = fopen(self::TEST_FILENAME, 'w');
        fwrite($fileDescriptor, $lines);
        fclose($fileDescriptor);
    }

    public function deleteTestFile()
    {
        if (file_exists(self::TEST_FILENAME)) {
            unlink(self::TEST_FILENAME);
        }
    }

    public function testFileLinesCounter()
    {
        $this->createTestFile();
        $linesCounter = new LinesCounter();
        $lineFilter = new RTrimFilter();
        $fileLinesCounter = new FileLinesCounter(self::TEST_FILENAME, $linesCounter, $lineFilter);
        $fileLinesCounter->countLines();
        $result = $fileLinesCounter->getTopLines(2);
        $this->assertEquals(2, count($result));
        $this->assertEquals(4, $result['c']);
        $this->assertEquals(2, $result['b']);
        $this->deleteTestFile();
    }

    public function testFileException()
    {
        $this->expectException('IponwebTest\FileLinesReader\Exception\FileException');
        $linesCounter = new LinesCounter();
        $lineFilter = new RTrimFilter();
        $fileLinesCounter = new FileLinesCounter('/tmp/'.md5(microtime(true)).'.txt', $linesCounter, $lineFilter);
        $fileLinesCounter->countLines();
    }

    public function testNumException()
    {
        $this->expectException('IponwebTest\LinesCounter\Exception\NumException');
        $this->createTestFile();
        $linesCounter = new LinesCounter();
        $lineFilter = new RTrimFilter();
        $fileLinesCounter = new FileLinesCounter(self::TEST_FILENAME, $linesCounter, $lineFilter);
        $fileLinesCounter->countLines();
        $result = $fileLinesCounter->getTopLines(200);
        $this->assertEquals(2, count($result));
        $this->assertEquals(4, $result['c']);
        $this->assertEquals(2, $result['b']);
        $this->deleteTestFile();
    }
}
