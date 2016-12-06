<?php

$input = file(__DIR__ . "/input", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$columns = array_fill(0, 7, []);
$charCounts = [];

foreach ($input as $line) {
    foreach (str_split($line) as $index => $char) {
        $columns[$index][] = $char;
    }
}

foreach ($columns as $index => $column) {
    $charCounts[$index] = array_count_values($column);
    arsort($charCounts[$index]);
}

foreach ($charCounts as $charCount) {
    echo(array_keys($charCount)[0]);
}

echo "\n";
