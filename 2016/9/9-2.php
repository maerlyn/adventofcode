<?php

$input = trim(file_get_contents(__DIR__ . "/input"));

function decompress($string)
{
    $returnSum = 0;

    while (true) {
        $pos = strpos($string, '(');

        if ($pos === false) {
            $returnSum += strlen($string);

            return $returnSum;
        }

        $returnSum += strlen(substr($string, 0, $pos));

        if (preg_match('/\((\d+)x(\d+)\)(.+)/', $string, $matches)) {
            $returnSum += ($matches[2] * decompress(
                    substr($matches[3], 0, $matches[1])
                ));
        }

        $string = substr($matches[3], $matches[1]);
    }
}

var_dump(decompress($input));
