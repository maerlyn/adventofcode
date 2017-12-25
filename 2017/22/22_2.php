<?php

$lines = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$grid = [];

foreach ($lines as $line) {
    $grid[] = str_split($line);
}

$currRow = (int)floor(count($grid) / 2);
$currCol = (int)floor(count($grid[$currRow]) / 2);
$currDir = 'U';
$burstInfections = 0;

$statusChanges = [
    '.' => 'W',
    'W' => '#',
    '#' => 'F',
    'F' => '.',
];

for ($i = 0; $i < 10000000; ++$i) {
    turn();

    $currVal = getGridAt($currRow, $currCol);

    if ($currVal == 'W') {
        ++$burstInfections;
    }

    setGridAt($currRow, $currCol, $statusChanges[$currVal]);

    move();
}

function getGridAt($row, $col)
{
    global $grid;
    return $grid[$row][$col] ?? '.';
}

function setGridAt($row, $col, $val)
{
    global $grid;

    if (!isset($grid[$row])) $grid[$row] = [];

    $grid[$row][$col] = $val;
}

function turn()
{
    global $currCol, $currRow, $currDir, $grid;
    static $turnLeft = ['U' => 'L', 'L' => 'D', 'D' => 'R', 'R' => 'U'];
    static $turnRight = ['U' => 'R', 'R' => 'D', 'D' => 'L', 'L' => 'U'];
    static $turnReverse = ['U' => 'D', 'D' => 'U', 'L' => 'R', 'R' => 'L'];

    switch ($grid[$currRow][$currCol] ?? '.') {
        case '.': $currDir = $turnLeft[$currDir]; break;
        case '#': $currDir = $turnRight[$currDir]; break;
        case 'F': $currDir = $turnReverse[$currDir]; break;
    }
}

function move()
{
    global $currDir, $currRow, $currCol;

    switch ($currDir) {
    case 'U': $currRow--; break;
    case 'D': $currRow++; break;
    case 'L': $currCol--; break;
    case 'R': $currCol++; break;
    }
}

var_dump($burstInfections);
