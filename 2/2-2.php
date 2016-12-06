<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));

$combination = "";

/*    1
  2 3 4
5 6 7 8 9
  A B C
    D*/

$keypad = [
    [0, 0, 1, 0, 0],
    [0, 2, 3, 4, 0],
    [5, 6, 7, 8, 9],
    [0, "A", "B", "C", 0],
    [0, 0, "D", 0, 0],
];

$position = [1, 1];

foreach ($input as $line) {
    foreach (str_split($line) as $move) {
        switch ($move) {
        case "L":
            if (@$keypad[$position[0]][$position[1] - 1]) {
                $position[1]--;
            }
            break;
        case "R":
            if (@$keypad[$position[0]][$position[1] + 1]) {
                $position[1]++;
            }
            break;
        case "U":
            if (@$keypad[$position[0] - 1][$position[1]]) {
                $position[0]--;
            }
            break;
        case "D":
            if (@$keypad[$position[0] + 1][$position[1]]) {
                $position[0]++;
            }
            break;
        }
    }

    var_dump($keypad[$position[0]][$position[1]]);
}
