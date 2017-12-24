<?php

$input = 361527;
$data = [];

function getIndex($x, $y) {
    global $data;

    if (!isset($data[$x])) {
        $data[$x] = [];
    }

    if (!isset($data[$x][$y])) {
        $data[$x][$y] = 0;
    }

//    var_dump($data[$x][$y]);
    return $data[$x][$y];
}

function setIndex($x, $y, $value) {
    global $data;

    if (!isset($data[$x])) {
        $data[$x] = [];
    }

    $data[$x][$y] = $value;
}

function dumpTable($layer) {
    for ($i = -($layer ** 2 / 2)+1; $i < $layer ** 2 / 2; ++$i) {
        for ($j = -($layer ** 2 / 2)+1; $j < $layer ** 2 / 2; ++$j) {
            echo getIndex($i, $j) . "\t";
        }
        echo "\n";
    }
}

function getNeighborSums($x, $y) {
    $sum = 0;

    for ($i = $x-1; $i <= $x+1; ++$i) {
        for ($j = $y-1; $j <= $y+1; ++$j) {
//            printf("%d %d - %d\n", $i, $j, getIndex($i, $j));

            if ($i == $x && $j == $y) continue;

            $sum += getIndex($i, $j);
        }
    }

    return $sum;
}

function fillIndex($x, $y) {
    setIndex($x, $y, getNeighborSums($x, $y));
}

$currentLayer = 1;
$currX = 0;
$currY = 0;

setIndex(0, 0, 1);

fillIndex(1, 0);
fillIndex(1, 1);
fillIndex(0, 1);
fillIndex(-1, 1);
fillIndex(-1, 0);
fillIndex(-1, -1);
fillIndex(0, -1);
fillIndex(1, -1);
fillIndex(2, -1);

dumpTable(2);
