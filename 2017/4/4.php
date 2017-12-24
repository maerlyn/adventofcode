<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$validCount = 0;

foreach ($input as $passphrase) {
    $words = explode(" ", $passphrase);
    $uniqueWords = array_unique($words);

    if (count($words) == count($uniqueWords)) { ++$validCount; }
}

var_dump($validCount);
