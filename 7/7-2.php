<?php

$input = file(__DIR__ . "/input", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

foreach ($input as $line) {
    if (preg_match('/(?![^\[]*])(.)((?!\1).)(\1).*\[[^\]]*?\2\1\2[^\]]*?\]/', $line) || preg_match('/\[[^\]]*?(.)((?!\1).)(\1)[^\]]*?\].*(?![^\[]*])\2\1\2/', $line)) {
        echo $line . "\n";
    }
}
