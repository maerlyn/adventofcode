<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);

preg_match('/^Begin in state ([A-Z]).$/', $input[0], $matches);
$currState = $matches[1];

preg_match('/^Perform a diagnostic checksum after ([0-9]+) steps.$/', $input[1], $matches);
$stopAfterSteps = $matches[1];

/*
 * $rules = [
 *      state ('A') => [
 *          value ('0') => [
 *              "write" => value ('1'),
 *              "move"  => +-1,
 *              "next"  => state ('C'),
 *          ],
 *      ],
 *      ...
 * ];
 * */

$rules = parseRules($input);
$tape = [0];
$currTapePos = 0;

for ($step = 0; $step < $stopAfterSteps; ++$step) {
    $currValue = $tape[$currTapePos] ?? 0;

    $tape[$currTapePos] = $rules[$currState][$currValue]["write"];
    $currTapePos += $rules[$currState][$currValue]["move"];
    $currState = $rules[$currState][$currValue]["next"];
}

var_dump(count(array_filter($tape)));

function parseRules(array $input)
{
    $rules = [];
    $rule = [];
    $processingState = '';
    $processingCurrentValue = '';
    for ($i = 3; $i < count($input); ++$i) {
        $line = $input[$i];

        if (preg_match('/^In state ([A-Z]):$/', $line, $matches)) {
            $processingState = $matches[1];
        } elseif (preg_match('/  If the current value is ([01]):/', $line, $matches)) {
            $processingCurrentValue = $matches[1];
        } elseif (preg_match('/    - Write the value ([01])./', $line, $matches)) {
            $rule[$processingCurrentValue]["write"] = $matches[1];
        } elseif (preg_match('/    - Move one slot to the (left|right)./', $line, $matches)) {
            $rule[$processingCurrentValue]["move"] = $matches[1] == "left" ? -1 : +1;
        } elseif (preg_match('/    - Continue with state ([A-Z])./', $line, $matches)) {
            $rule[$processingCurrentValue]["next"] = $matches[1];
        } elseif (empty($line)) {
            $rules[$processingState] = $rule;
            $rule = [];
        }
    }
    $rules[$processingState] = $rule;

    return $rules;
}


