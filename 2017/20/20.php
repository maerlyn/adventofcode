<?php

$lines = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$particles = [];

foreach ($lines as $line) {
    preg_match('/^p=<(?P<px>[-\d]+),(?P<py>[-\d]+),(?P<pz>[-\d]+)>, v=<(?P<vx>[-0-9]+),(?P<vy>[-\d]+),(?P<vz>[-\d]+)>, a=<(?P<ax>[-0-9]+),(?P<ay>[-\d]+),(?P<az>[-\d]+)>$/s', $line, $matches);
    $particles[] = [
        "px" => $matches["px"],
        "py" => $matches["py"],
        "pz" => $matches["pz"],
        "vx" => $matches["vx"],
        "vy" => $matches["vy"],
        "vz" => $matches["vz"],
        "ax" => $matches["ax"],
        "ay" => $matches["ay"],
        "az" => $matches["az"],
    ];
}

// find lowest acceleration
$lowestAccel = PHP_INT_MAX;
$lowestAccelCount = 0;
$lowestAccelIndex = 0;

foreach ($particles as $k => $particle) {
    $accel = abs($particle["ax"]) + abs($particle["ay"]) + abs($particle["az"]);

    if ($accel < $lowestAccel) {
        $lowestAccel = $accel;
        $lowestAccelCount = 1;
        $lowestAccelIndex = $k;
    } else if ($accel == $lowestAccel) {
        ++$lowestAccelCount;
    }
}

var_dump($lowestAccelIndex, $particles[$lowestAccelIndex]);
