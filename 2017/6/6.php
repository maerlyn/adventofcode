<?php

$input = "14 0 15 12 11 11 3 5 1 6 8 4 9 1 8 4";

$seenConfigurations = [];
$memoryBanks = explode(" ", $input);

while (!in_array(implode(" ", $memoryBanks), $seenConfigurations)) {
    $seenConfigurations[] = implode(" ", $memoryBanks);

    $fullestBank = 0;
    for ($i = 0; $i < count($memoryBanks); ++$i) {
        if ($memoryBanks[$i] > $memoryBanks[$fullestBank]) {
            $fullestBank = $i;
        }
    }

    $toDistribute = $memoryBanks[$fullestBank];
    $memoryBanks[$fullestBank] = 0;

    for ($i = 1; $i <= $toDistribute; ++$i) {
        $memoryBanks[($fullestBank + $i) % count($memoryBanks)]++;
    }
}

//part1
var_dump(count($seenConfigurations));

//part 2
$index = array_search(implode(" ", $memoryBanks), $seenConfigurations);
var_dump(count($seenConfigurations) - $index);
