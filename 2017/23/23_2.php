<?php

$instructions = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$eip = 0;
$registers = [
    'a' => 1,
    'b' => 0,
    'c' => 0,
    'd' => 0,
    'e' => 0,
    'f' => 0,
    'g' => 0,
    'h' => 0,
];

while (isset($instructions[$eip])) {
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
        $registers[$matches["reg"]] = $val;
        ++$eip;
        break;

    case 'sub':
        preg_match('/^sub (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
        if (empty($matches)) { var_dump($instruction); die(); }
        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);
        $registers[$matches["reg"]] = ($registers[$matches["reg"]] ?? 0) - $val;
        ++$eip;
        break;

    case 'mul':
        preg_match('/^mul (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
        if (empty($matches)) { var_dump($instruction); die(); }
        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);
        $registers[$matches["reg"]] = ($registers[$matches["reg"]] ?? 0) * $val;
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

    case 'jnz':
        preg_match('/^jnz (?P<reg>([-a-z0-9])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);

        if (empty($matches)) { var_dump($instruction);die(); }

        $reg = is_numeric($matches["reg"]) ? $matches["reg"] : ($registers[$matches["reg"]] ?? 0);
        $val = is_numeric($matches["val"]) ? $matches["val"] : ($registers[$matches["val"]] ?? 0);

        if ($reg != 0) {
            $eip += $val;
        } else {
            ++$eip;
        }

        break;

    default:
        die('unknown: ' . $instruction . "\n");
    }
}

var_dump($registers['h']);
