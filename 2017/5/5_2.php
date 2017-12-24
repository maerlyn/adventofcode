<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$eip = 0;

$eip = 0;
$steps = 0;

while (0 <= $eip && $eip < count($input)) {
    $nextEip = $eip + $input[$eip];

    if ($input[$eip] >= 3) --$input[$eip];
    else ++$input[$eip];
    $eip = $nextEip;

    ++$steps;
}

var_dump($steps);
