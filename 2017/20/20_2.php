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

$rounds = 1;
while (true) {
    echo "round " . $rounds++ . ", particles: " . count($particles) . "\n";
    $particles = removeCollisions($particles);

    foreach ($particles as &$particle) {
        $particle["vx"] += $particle["ax"];
        $particle["vy"] += $particle["ay"];
        $particle["vz"] += $particle["az"];

        $particle["px"] += $particle["vx"];
        $particle["py"] += $particle["vy"];
        $particle["pz"] += $particle["vz"];
    }
    unset($particle);
}

function removeCollisions($particles)
{
    foreach ($particles as $subjectIndex => $subject) {
        foreach ($particles as $targetIndex => $target) {
            if ($subjectIndex == $targetIndex) continue;

            if (
                $subject["px"] == $target["px"] &&
                $subject["py"] == $target["py"] &&
                $subject["pz"] == $target["pz"]
            ) {
                unset($particles[$subjectIndex]);
                unset($particles[$targetIndex]);
                continue 2;
            }
        }
    }

    return $particles;
}
