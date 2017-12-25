<?php

$instructions = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$eip = 0;
$registers = [];
$lastSound = 0;

while (true) {
    $instruction = $instructions[$eip];

    switch (substr($instruction, 0, 3)) {
    case 'snd':
        $reg = substr($instruction, 4);
        $lastSound = $registers[$reg] ?? 0;
        ++$eip;
        break;

    case 'set':
        preg_match('/^set (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);
        $registers[$matches["reg"]] = $matches["val"];
        ++$eip;
        break;

    case 'add':
        preg_match('/^add (?P<reg>([a-z])) (?P<val>([-0-9]+))$/s', $instruction, $matches);
        $registers[$matches["reg"]] = ($registers[$matches["reg"]] ?? 0) + $matches["val"];
        ++$eip;
        break;

    case 'mul':
        preg_match('/^mul (?P<reg>([a-z])) (?P<val>([-0-9]+))$/s', $instruction, $matches);

        $registers[$matches["reg"]] = ($registers[$matches["reg"]] ?? 0) * $matches["val"];
        ++$eip;
        break;

    case 'mod':
        preg_match('/^mod (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);
        $registers[$matches["reg"]] = ($registers[$matches["reg"]] ?? 0) % $val;
        ++$eip;
        break;

    case 'rcv':
        preg_match('/^rcv (?P<reg>([a-z]))$/s', $instruction, $matches);

        if (($registers[$matches["reg"]] ?? 0) != 0) {
            break 2;
        }

        ++$eip;
        break;

    case 'jgz':
        preg_match('/^jgz (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);

        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);

        if (($registers[$matches["reg"]] ?? 0) != 0) {
            $eip += $val;
        } else {
            ++$eip;
        }

        break;
    }
}

var_dump($lastSound);
