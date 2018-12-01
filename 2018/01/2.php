<?php

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES);

$currentFrequency = 0;
$metFrequencies = [];

while (true) {
    foreach ($input as $v) {
        $v = intval(trim($v));
        $currentFrequency += $v;

	if (isset($metFrequencies[$currentFrequency])) {
	    echo $currentFrequency . "\n";
	    die();
	}

	$metFrequencies[$currentFrequency] = 1;
    }
}
