<?php
namespace IponwebTest\FileLinesReader;

use IponwebTest\FileLinesReader\Interfaces\IFileLinesCounter;
use IponwebTest\LinesCounter\Interfaces\ILinesCounter;
use IponwebTest\LineFilter\Interfaces\ILineFilter;
use IponwebTest\FileLinesReader\Exception\FileException;


class FileLinesCounter implements IFileLinesCounter
{
    protected $fileName;
    protected $linesCounter;
    protected $lineFilter;
    protected $fileDescriptor;

    public function __construct($fileName, ILinesCounter $linesCounter, ILineFilter $lineFilter)
    {
        $this->fileName = $fileName;
        $this->linesCounter = $linesCounter;
        $this->lineFilter = $lineFilter;
    }

    public function countLines()
    {
        $this->checkFile();
        $this->openFile();
        $this->readFile();
        $this->closeFile();
    }

    public function getTopLines($topNum=null)
    {
        return $this->linesCounter->getTop($topNum);
    }

    protected function checkFile()
    {
        if (!file_exists($this->fileName)) {
            throw new FileException('File does not exist!');
        }
        if (!is_readable($this->fileName)) {
            throw new FileException('File is not readable!');
        }
    }

    protected function openFile()
    {
        $this->fileDescriptor = fopen($this->fileName, 'r');
    }

    protected function readFile()
    {
        while ($line = $this->getLine()) {
            $line = $this->lineFilter->filter($line);
            if ($line === false) {
                continue;
            }
            $this->linesCounter->increment($line);
        }
    }

    protected function getLine()
    {
        while ($line = fgets($this->fileDescriptor)) {
            return $line;
        }
        return false;
    }

    protected function closeFile()
    {
        fclose($this->fileDescriptor);
    }
}
