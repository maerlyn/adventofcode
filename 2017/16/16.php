<?php

$input = explode(",", trim(file_get_contents(__DIR__ . "/input")));
$programs = 'abcdefghijklmnop';

foreach ($input as $move) {
    switch ($move[0]) {
    case 's':
        $length = substr($move, 1);
        $programs = substr($programs, -1 * $length) . substr($programs, 0, -1 * $length);
        break;

    case 'x':
        $positions = explode("/", substr($move, 1));
        $tmp = $programs[$positions[0]];
        $programs[$positions[0]] = $programs[$positions[1]];
        $programs[$positions[1]] = $tmp;
        break;

    case 'p':
        $partners = explode("/", substr($move, 1));
        $p0pos = strpos($programs, $partners[0]);
        $p1pos = strpos($programs, $partners[1]);
        $tmp = $programs[$p0pos];
        $programs[$p0pos] = $programs[$p1pos];
        $programs[$p1pos] = $tmp;
        break;
    }
}

var_dump($programs);
