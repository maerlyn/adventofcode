<?php

$input = 361527;

$layerWidth = 1;
$layerMax = 1;
while ($input > $layerMax) {
    $layerWidth += 2;
    $layerMax = $layerWidth ** 2;
}
$layerWidthHalf = ($layerWidth - 1) / 2;

$midway = $layerMax - (($layerWidth - 1) * 2);

if ($input == $midway || $input == $layerMax) {
    return $layerWidth - 1;
}
if ($input > $midway) {
    $diff = $layerMax - $input;
}
if ($input < $midway) {
    $diff = $midway - $input;
}
if ($diff >= $layerWidth) {
    $diff = $layerWidthHalf + abs($diff - ($layerWidth - 1) - $layerWidthHalf);
}
else {
    $diff = abs($diff - $layerWidthHalf) + $layerWidthHalf;
}

var_dump($diff);
