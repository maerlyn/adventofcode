<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));

$possibleCounter = 0;
$inputMatrix = [];

foreach ($input as $line) {
    preg_match('#(\d+)\s+(\d+)\s+(\d+)#', $line, $matches);
    unset($matches[0]);
    $matches = array_map('intval', $matches);

    $inputMatrix[] = [$matches[1], $matches[2], $matches[3]];
}

for ($i = 0; $i < count($inputMatrix); $i += 3) {
    for ($j = 0; $j <= 2; ++$j) {
        $sides = [
            $inputMatrix[$i][$j],
            $inputMatrix[$i+1][$j],
            $inputMatrix[$i+2][$j],
        ];

        sort($sides);

        if ($sides[0] + $sides[1] > $sides[2]) ++$possibleCounter;
    }
}

var_dump($possibleCounter);
