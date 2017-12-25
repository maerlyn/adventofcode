<?php

$lines = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$diagram = [];

foreach ($lines as $line) {
    $diagram[] = str_split($line);
}

$currRow = 0;
$currCol = array_search('|', $diagram[$currRow]);
$currDir = 'D';
$letters = '';
$steps = 0;

while (true) {
    if (!isset($diagram[$currRow][$currCol])) {
        var_dump($currRow, $currCol);
        die('kimentunk a palyarol');
    }

    $currChar = $diagram[$currRow][$currCol];
    echo $currChar . " ";

    if (preg_match('/[A-Z]/', $currChar)) {
        $letters .= $currChar;
        step();
    } else {
        switch ($currChar) {
        case '|':
        case '-':
            echo "step $currDir\n";
            step();
            break;
        case '+':
            if ($currDir != 'D' && $diagram[$currRow-1][$currCol] == '|') $currDir = 'U';
            else
            if ($currDir != 'U' && $diagram[$currRow+1][$currCol] == '|') $currDir = 'D';
            else
            if ($currDir != 'L' && $diagram[$currRow][$currCol+1] == '-') $currDir = 'R';
            else
            if ($currDir != 'R' && $diagram[$currRow][$currCol-1] == '-') $currDir = 'L';
            else
                break;

            echo "new dir $currDir\n";
            step();
            break;
        default:
            var_dump($letters);
            var_dump("unknown char: >" . $currChar . "< probably finished");
            var_dump("$steps steps");
            die();
        }
    }
}

var_dump($letters);

function step()
{
    global $currRow, $currCol, $currDir, $steps;
    ++$steps;

    switch ($currDir) {
    case 'D': $currRow++; break;
    case 'U': $currRow--; break;
    case 'L': $currCol--; break;
    case 'R': $currCol++; break;
    }
}
