<?php

$input = "ffykfhsq";
$password = "";
$index = 0;

while (strlen($password) < 8) {
    while (substr(md5($input . $index), 0, 5) !== "00000") {
        echo "\r" . $index;
        ++$index;
    }

    echo "{$input} {$index} " . md5($input . $index) . "\n";
    $password .= substr(md5($input . $index), 5, 1);
    echo "\n" . $password . "\n";

    ++$index;
}
