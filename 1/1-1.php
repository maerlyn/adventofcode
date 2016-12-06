<?php

$input = explode(", ", file_get_contents(__DIR__ . "/input"));

$currentPosition = ["x" => 0, "y" => 0];
$currentDirection = "N";

$directions = [
    "L" => ["N" => "W", "W" => "S", "S" => "E", "E" => "N"],
    "R" => ["N" => "E", "E" => "S", "S" => "W", "W" => "N"],
];

$directionMultipliers = [
    "N" => ["y" => 1],
    "W" => ["x" => -1],
    "S" => ["y" => -1],
    "E" => ["x" => 1],
];

foreach ($input as $step) {
    $stepDirection = $step[0];
    $stepLength = substr($step, 1);

    $currentDirection = $directions[$stepDirection][$currentDirection];

    if (isset($directionMultipliers[$currentDirection]["x"])) {
        $currentPosition["x"] += $stepLength * $directionMultipliers[$currentDirection]["x"];
    }
    if (isset($directionMultipliers[$currentDirection]["y"])) {
        $currentPosition["y"] += $stepLength * $directionMultipliers[$currentDirection]["y"];
    }
}

var_dump("fin", $currentPosition);
