<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$parents = [];

foreach ($input as $line) {
    if (false === strpos($line, "->")) {
        // topmost, has no children
        continue;
    }

    list($nameAndWeight, $children) = explode(" -> ", $line);
    list($name, ) = explode(" ", $nameAndWeight);
    $children = explode(", ", $children);

    if (!isset($parents[$name])) {
        $parents[$name] = false;
    }
    foreach ($children as $child) {
        $parents[$child] = $name;
    }
}

var_dump(array_filter($parents, function ($v) { return $v == false; }));
