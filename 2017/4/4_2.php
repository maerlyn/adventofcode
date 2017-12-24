<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$validCount = 0;

foreach ($input as $passphrase) {
    $words = explode(" ", $passphrase);

    for ($i = 0; $i < count($words); ++$i) {
        $word = $words[$i];
        $word = str_split($word);
        sort($word);
        $words[$i] = implode("", $word);
    }

    $uniqueWords = array_unique($words);

    if (count($words) == count($uniqueWords)) { ++$validCount; }
}

var_dump($validCount);
