<?php

$input = array_map(function ($line) { return trim($line); }, array_filter(file(__DIR__ . "/input")));

$sum = 0;
foreach ($input as $line) {
    $numbers = explode("\t", $line);

    $sum += abs(min($numbers) - max($numbers));
}

var_dump($sum);
