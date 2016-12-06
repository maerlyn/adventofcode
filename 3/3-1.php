<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));

$possibleCounter = 0;

foreach ($input as $line) {
    preg_match('#(\d+)\s+(\d+)\s+(\d+)#', $line, $matches);
    unset($matches[0]);
    $matches = array_map('intval', $matches);
    sort($matches);

    if ($matches[0] + $matches[1] > $matches[2]) ++$possibleCounter;
}

var_dump($possibleCounter);
