<?php

/*ioe dec 890 if qk > -10
gif inc -533 if qt <= 7
itw dec 894 if t != 0
nwe inc 486 if hfh < -2
*/

$input = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
$registers = [];
$highest_ever = PHP_INT_MIN;

function getRegister($name)
{
    global $registers;
    return $registers[$name] ?? 0;
}

function setRegister($name, $value)
{
    global $registers, $highest_ever;
    $registers[$name] = $value;

    if ($value > $highest_ever) {
        $highest_ever = $value;
    }
}

function applyOperation($register, $operator, $operand)
{
    $value = getRegister($register);

    switch ($operator) {
        case "inc": $value += $operand; break;
        case "dec": $value -= $operand; break;
    }

    setRegister($register, $value);
}

function evaluateCondition($register, $operator, $operand)
{
    $value = getRegister($register);

    switch ($operator) {
        case ">":  return $value > $operand;
        case "<":  return $value < $operand;
        case "<=": return $value <= $operand;
        case ">=": return $value >= $operand;
        case "!=": return $value != $operand;
        case "==": return $value == $operand;
        default: die("unknown: " . $operator . "\n");
    }
}

foreach ($input as $instruction)
{
    if (!preg_match('/^(?P<register>(\w+)) (?P<operator>(inc|dec)) (?P<operand>(-?\d)+) if (?P<if_register>(\w+)) (?P<if_operator>([<>=!]+)) (?P<if_operand>(-?\d+))$/s', $instruction, $matches)) {
        die("wtf");
    }

    extract($matches, EXTR_OVERWRITE);
    echo $instruction . "\n";

    if (evaluateCondition($if_register, $if_operator, $if_operand)) {
        applyOperation($register, $operator, $operand);
    }
}

arsort($registers);

echo "highest value currently is " . array_values($registers)[0] . "\n";
echo "highest ever is $highest_ever\n";
