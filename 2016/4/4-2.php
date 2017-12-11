<?php

$input = explode("\n", trim(file_get_contents(__DIR__ . "/input")));
$validSectorIds = 0;

function str_rot($s, $n = 13) {
    static $letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
    $n = (int)$n % 26;
    if (!$n) return $s;
    if ($n < 0) $n += 26;
    if ($n == 13) return str_rot13($s);
    $rep = substr($letters, $n * 2) . substr($letters, 0, $n * 2);
    return strtr($s, $letters, $rep);
}

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

    echo str_rot($matches["name"], intval($matches["sector"])) . " - " . $matches["sector"] . "\n";
}

