<?php

$input = trim(file_get_contents(__DIR__ . "/input"));
$pos = 0;
$uncompressed = "";

while ($pos < strlen($input)) {
    if ($input[$pos] === "(") {
        $closePos = strpos($input, ")", $pos);
        $marker = substr($input, $pos+1, $closePos - $pos - 1);
        list($charLen, $times) = explode('x', $marker);
        $substring = substr($input, $closePos + 1, $charLen);

        echo "marker {$marker}, repeating {$substring} {$times} times\n";

        $uncompressed .= str_repeat($substring, $times);
        $pos = $closePos + strlen($substring) + 1;
    } else {
        echo "literal {$input[$pos]}\n";
        $uncompressed .= $input[$pos++];
    }
}

var_dump(strlen($uncompressed));
