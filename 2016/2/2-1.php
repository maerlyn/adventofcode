<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));

$combination = "";

$keypad = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];

$position = [1, 1];

foreach ($input as $line) {
    foreach (str_split($line) as $move) {
        switch ($move) {
        case "L": $position[1] = max(0, $position[1] - 1); break;
        case "R": $position[1] = min(2, $position[1] + 1); break;
        case "U": $position[0] = max(0, $position[0] - 1); break;
        case "D": $position[0] = min(2, $position[0] + 1); break;
        }
    }

    var_dump($keypad[$position[0]][$position[1]]);
}
