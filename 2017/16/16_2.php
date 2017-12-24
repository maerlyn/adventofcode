<?php

$input = explode(",", trim(file_get_contents(__DIR__ . "/input")));
$programs = 'abcdefghijklmnop';
$seenPositions = [$programs];

function applyMoves($programs, $input)
{
    foreach ($input as $move) {
        switch ($move[0]) {
        case 's':
            $length = substr($move, 1);
            $programs = substr($programs, -1 * $length) . substr(
                    $programs, 0, -1 * $length
                );
            break;

        case 'x':
            $positions = explode("/", substr($move, 1));
            $tmp = $programs[$positions[0]];
            $programs[$positions[0]] = $programs[$positions[1]];
            $programs[$positions[1]] = $tmp;
            break;

        case 'p':
            $partners = explode("/", substr($move, 1));
            $p0pos = strpos($programs, $partners[0]);
            $p1pos = strpos($programs, $partners[1]);
            $tmp = $programs[$p0pos];
            $programs[$p0pos] = $programs[$p1pos];
            $programs[$p1pos] = $tmp;
            break;
        }
    }

    return $programs;
}

for ($i = 0; $i < 1e9; ++$i) {
    $programs = applyMoves($programs, $input);

    if (in_array($programs, $seenPositions)) {
        var_dump("cycle len " . count($seenPositions));
        break;
    }

    $seenPositions[] = $programs;
}

$remainingCycles = 1e9 % count($seenPositions);
$programs = 'abcdefghijklmnop';

for ($i = 0; $i < $remainingCycles; ++$i) {
    $programs = applyMoves($programs, $input);
}

var_dump($programs);
