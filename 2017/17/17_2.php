<?php

$input = 337;
$currentIndex = 0;
$first = 1;

for ($i = 1; $i <= 50 * 1e6; ++$i) {
    $currentIndex = ($currentIndex + $input % $i + 1) % $i;
    if ($currentIndex == 0) $first = $i;
}

var_dump($first);
