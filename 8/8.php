<?php

$input = file(__DIR__ . "/input", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$screen = array_fill(0, 6, array_fill(0, 50, " "));

function dumpScreen() {
    global $screen;

    foreach ($screen as $row) {
        foreach ($row as $pixel) {
            echo $pixel;
        }

        echo "\n";
    }
}

dumpScreen();

foreach ($input as $line) {
    echo $line . "\n";

    switch (true) {
        case "rect" === substr($line, 0, 4):
            list($A, $B) = explode("x", explode(" ", $line)[1]);
            for ($i = 0; $i < $A; ++$i) {
                for ($j = 0; $j < $B; ++$j) {
                    $screen[$j][$i] = "#";
                }
            }
            dumpScreen();
            break;

        case "rotate column" === substr($line, 0, 13):
            preg_match('#x=(\d+) by (\d+)$#', $line, $matches);
            list(, $columnNumber, $offset) = $matches;

            $column = array_column($screen, (int) $columnNumber);

            for ($y = 0; $y < count($screen); ++$y) {
                $pos = ($y + $offset) % count($screen);
                $screen[$pos][$columnNumber] = $column[$y];
            }

            dumpScreen();
            break;

        case "rotate row" === substr($line, 0, 10):
            preg_match('#y=(\d+) by (\d+)$#', $line, $matches);
            for ($i = 0; $i < $matches[2]; ++$i) {
                array_unshift($screen[$matches[1]], array_pop($screen[$matches[1]]));
            }
            dumpScreen();
            break;
    }
}

$lit = 0;
for ($i = 0; $i < count($screen); ++$i) {
    for ($j = 0; $j < count($screen[$i]); ++$j) {
        $lit += $screen[$i][$j] == '#' ? 1 : 0;
    }
}

var_dump($lit);
