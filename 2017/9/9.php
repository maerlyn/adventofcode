<?php

$input = trim(file_get_contents(__DIR__ . "/input"));

$garbage = false;
$score = 0;
$depth = 0;
$garbageCount = 0;

for ($i = 0, $c = $input[0]; $i <= strlen($input); ++$i, $c = $input[$i]) {
    if ($c == '!') ++$i;
    else if ($garbage && $c != '>') ++$garbageCount;
    else if ($c == '<') $garbage = true;
    else if ($c == '>') $garbage = false;
    else if ($c == '{') $score += $depth++;
    else if ($c == '}') --$depth;
}

var_dump("score", $score, "gc", $garbageCount);
