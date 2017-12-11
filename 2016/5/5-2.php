<?php

$input = "ffykfhsq";
$password = str_repeat("_", 8);
$index = 0;

while (false !== strpos($password, "_")) {
    $hash = md5($input . $index);

    while (substr($hash, 0, 5) !== "00000") {
        echo "\r {$hash} {$password}";
        ++$index;
        $hash = md5($input . $index);
    }

    $position = $hash[5];
    $char = $hash[6];

    echo " " . $hash . "\n";

    if (is_numeric($position) && (0 <= $position && $position <= 7) && "_" === substr($password, $position, 1)) {
        $password[$position] = $char;
    }

    ++$index;
}

var_dump($password);
