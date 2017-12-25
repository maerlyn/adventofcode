<?php

error_reporting(0);

echo "\nSolution part 1: " . run_the_code(['rules' => getRealInput(), 'runs' => 5]);
echo "\nSolution part 2: " . run_the_code(['rules' => getRealInput(), 'runs' => 18]);

function run_the_code($input) {
    $lines = $input['rules'];
    $runs = $input['runs'];

    $lines = explode(PHP_EOL, $lines);
    $rules = [];
    foreach ($lines as $line) {
        if (preg_match('|(.*) => (.*)|', $line, $matches)) {
            list($_, $a, $b) = $matches;
            $rules[$a] = $b;
        }
    }

    $pattern = '.#./..#/###';
    for ($run = 0; $run < $runs; $run++) {
        $size = sqrt(strlen($pattern) - substr_count($pattern, '/'));
        if ($size % 2 == 0) {
            $blockSize = 2;
        }
        else { // divisible by 3
            $blockSize = 3;
        }

        $parts = [];
        $rows = explode('/', $pattern);
        for ($p1 = 0; $p1 < $size / $blockSize; $p1++) { // block-row per row
            for ($p2 = 0; $p2 < $size / $blockSize; $p2++) { // block-col per col in this row
                $part = [];
                for ($r = $p1 * $blockSize; $r < ($p1 * $blockSize) + $blockSize; $r++) {
                    $part[] = substr($rows[$r], $p2 * $blockSize, $blockSize);
                }
                $parts[] = implode('/', $part);
            }
        }

        // foreach part, flip and turn it around in all configurations, to find a match in the $rules
        $transforms = []; // the transformed (expanded) results of each part
        foreach ($parts as $part) {
            $t = [];
            $t[] = $part; // add the original part
            $t[] = rotate($t[0]); // 90°
            $t[] = rotate($t[1]); // 180°
            $t[] = rotate($t[2]); // 270°
            $t[] = flip($t[0]);
            $t[] = flip($t[1]);
            $t[] = flip($t[2]);
            $t[] = flip($t[3]);

            $found = false;
            foreach ($t as $item) {
                if (array_key_exists($item, $rules)) {
                    $transforms[] = $rules[$item];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                die("no pattern found! $part");
            }
        }

        // now put the transformed parts back into a new pattern
        $newparts = [];
        $newblocksize = $blockSize + 1;

        $c = 0;
        for ($p1 = 0; $p1 < $size / $blockSize; $p1++) { // block-row per row
            for ($p2 = 0; $p2 < $size / $blockSize; $p2++) { // block-col per col in this row
                $t = explode('/', $transforms[$c]);

                for ($r = 0; $r < $newblocksize; $r++) {
                    $newparts[($p1 * $newblocksize) + $r] .= $t[$r];
                }
                $c++;
            }
        }
        $pattern = implode('/', $newparts);
    }

    return substr_count($pattern, '#');
}

function rotate($pattern) {
    // rotates 90° on the pattern
    if (strlen($pattern) == 11) {
        $new = '.../.../...';
        $new[0] = $pattern[8];
        $new[1] = $pattern[4];
        $new[2] = $pattern[0];
        $new[4] = $pattern[9];
        $new[5] = $pattern[5];
        $new[6] = $pattern[1];
        $new[8] = $pattern[10];
        $new[9] = $pattern[6];
        $new[10] = $pattern[2];
    }
    else {
        $new = '../..';
        $new[0] = $pattern[3];
        $new[1] = $pattern[0];
        $new[3] = $pattern[4];
        $new[4] = $pattern[1];
    }
    return $new;
}

function flip($pattern) {
    // flips horizontally
    if (strlen($pattern) == 11) {
        $new = '.../.../...';
        $new[0] = $pattern[2];
        $new[1] = $pattern[1];
        $new[2] = $pattern[0];
        $new[4] = $pattern[6];
        $new[5] = $pattern[5];
        $new[6] = $pattern[4];
        $new[8] = $pattern[10];
        $new[9] = $pattern[9];
        $new[10] = $pattern[8];
    }
    else {
        $new = '../..';
        $new[0] = $pattern[1];
        $new[1] = $pattern[0];
        $new[3] = $pattern[4];
        $new[4] = $pattern[3];
    }
    return $new;
}

function getRealInput() {
    return file_get_contents(__DIR__ . "/input");
}
