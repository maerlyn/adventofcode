<?php

$input = "197,97,204,108,1,29,5,71,0,50,2,255,248,78,254,63";
$maxRange = 255;

$lengths = explode(',', $input);
$list = range(0, $maxRange);
$size = $maxRange + 1;
$skip = 0;
$start = 0;
foreach ($lengths as $length) {
    $sublist = [];
    for ($i = 0; $i < $length; $i++) {
        $sublist[] = $list[($start + $i) % $size];
    }
    $sublist = array_reverse($sublist);
    for ($i = 0; $i < $length; $i++) {
        $list[($start + $i) % $size] = $sublist[$i];
    }
    $start += $length + $skip;
    $skip++;
}

var_dump($list[0] * $list[1]);
