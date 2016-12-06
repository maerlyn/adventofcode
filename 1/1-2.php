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

$visitedPositions = [];
$visitedPositions[0][0] = 1;

foreach ($input as $step) {
    $stepDirection = $step[0];
    $stepLength = substr($step, 1);

    $currentDirection = $directions[$stepDirection][$currentDirection];

    if (isset($directionMultipliers[$currentDirection]["x"])) {
        for ($i = 0; $i < $stepLength; $i++) {
            $currentPosition["x"] += 1 * $directionMultipliers[$currentDirection]["x"];


            @$visitedPositions[$currentPosition["x"]][$currentPosition["y"]]++;

            if ($visitedPositions[$currentPosition["x"]][$currentPosition["y"]] == 2) {
                var_dump($currentPosition);
            }
        }
    }
    if (isset($directionMultipliers[$currentDirection]["y"])) {
        for ($i = 0; $i < $stepLength; $i++) {
            $currentPosition["y"] += 1 * $directionMultipliers[$currentDirection]["y"];

            @$visitedPositions[$currentPosition["x"]][$currentPosition["y"]]++;

            if ($visitedPositions[$currentPosition["x"]][$currentPosition["y"]] == 2) {
                var_dump($currentPosition);
            }
        }
    }
}
