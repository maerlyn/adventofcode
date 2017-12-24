<?php

$input = "197,97,204,108,1,29,5,71,0,50,2,255,248,78,254,63";
$maxRange = 255;

$lengths = [];
if ($input) { // just for the test case 'empty string'
    $lengths = array_map('ord', str_split($input));
}
array_push($lengths, '17', '31', '73', '47', '23');

$list = range(0, $maxRange);
$size = $maxRange + 1;
$skip = 0;
$start = 0;
for ($run = 0; $run < 64; $run++) {
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
}

$hash = '';

$chunks = array_chunk($list, 16);
for ($i = 0; $i < 16; $i++) {
    $xorred = $chunks[$i][0];
    for ($j = 1; $j < 16; $j++) {
        $xorred ^= $chunks[$i][$j];
    }
    $hash .= sprintf('%02s', dechex($xorred));
}

var_dump($hash);
