<?php

$input = array_map(function ($line) { return trim($line); }, array_filter(file(__DIR__ . "/input")));

$sum = 0;
foreach ($input as $line) {
    $numbers = explode("\t", $line);

    foreach ($numbers as $index_j => $j) {
        foreach ($numbers as $index_k => $k) {
            if ($index_j == $index_k) continue;

            if ($j % $k == 0) {
                $sum += $j / $k;
                continue 2;
            }
        }
    }
}

var_dump($sum);
