<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));
$validSectorIds = 0;

foreach ($input as $line) {
    preg_match('#^(?P<name>[a-z-]+)-(?P<sector>\d+)\[(?P<checksum>[a-z]+)\]$#', $line, $matches);

    $name = str_replace("-", "", $matches["name"]);
    $countValues = array_count_values(str_split($name));
    arsort($countValues);

    $occurences = [];
    foreach ($countValues as $k => $v) {
        @$occurences[$v][] = $k;
    }

    $checksum = "";
    foreach ($occurences as $k => $v) {
        sort($occurences[$k]);

        $checksum .= implode("", $occurences[$k]);
    }

    $checksum = substr($checksum, 0, 5);

    if ($checksum === $matches["checksum"]) {
        $validSectorIds += intval($matches["sector"]);
    }
}

var_dump($validSectorIds);
