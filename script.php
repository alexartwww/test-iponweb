<?php
require_once __DIR__ . '/vendor/autoload.php';

use IponwebTest\LinesCounter\LinesCounter;
use IponwebTest\LineFilter\RTrimFilter\RTrimFilter;
use IponwebTest\FileLinesReader\FileLinesCounter;
use IponwebTest\FileLinesReader\Exception\FileException;
use IponwebTest\LinesCounter\Exception\NumException;

try {
    if (!isset($_SERVER['argv'][1])|| !isset($_SERVER['argv'][2])) {
        throw new \Exception('Argument error! Format is: php ./script.php filename num');
    }
    $fileName = $_SERVER['argv'][1];
    $num = intval($_SERVER['argv'][2]);
    $linesCounter = new LinesCounter();
    $lineFilter = new RTrimFilter();
    $fileLinesCounter = new FileLinesCounter($fileName, $linesCounter, $lineFilter);
    $fileLinesCounter->countLines();
    $result = $fileLinesCounter->getTopLines($num);
    $output = '';
    foreach ($result as $line => $num)
    {
        $output .= $line . ': ' . $num . "\n";
    }
    $std = fopen('php://stdout', 'w');
    fwrite($std, $output);
    fclose($std);
} catch (FileException $exception) {
    $std = fopen('php://stderr', 'w');
    fwrite($std, 'ERROR: ' . $exception->getMessage() . "\n");
    fclose($std);
} catch (NumException $exception) {
    $std = fopen('php://stderr', 'w');
    fwrite($std, 'ERROR: ' . $exception->getMessage() . "\n");
    fclose($std);
} catch (\Exception $exception) {
    $std = fopen('php://stderr', 'w');
    fwrite($std, 'ERROR: ' . $exception->getMessage() . "\n");
    fclose($std);
}
