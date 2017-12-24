<?php

$input = 337;
$buffer = [0];
$currentIndex = 0;

for ($i = 1; $i <= 2017; ++$i) {
    $currentIndex = ($currentIndex + $input) % count($buffer);

    $buffer = array_merge(
        array_slice($buffer, 0, $currentIndex),
        [$i],
        array_slice($buffer, $currentIndex)
    );

    ++$currentIndex;
}

var_dump($buffer[$currentIndex]);
