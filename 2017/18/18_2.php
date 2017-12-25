<?php

class Program
{
    protected $instructions;
    protected $eip;
    protected $registers;
    protected $pid;

    protected $receiveBuffer = [];
    protected $isBlocked = false;

    public function __construct($pid)
    {
        $this->instructions = file(__DIR__ . "/input", FILE_IGNORE_NEW_LINES);
        $this->eip = 0;
        $this->registers = ["p" => $pid];
        $this->pid = $pid;
    }

    public function run()
    {
        while (isset($this->instructions[$this->eip])) {
            $instruction = $this->instructions[$this->eip];

            switch (substr($instruction, 0, 3)) {
            case 'snd':
                $reg = substr($instruction, 4);
                send($this->pid, $this->registers[$reg]);
                ++$this->eip;
                break;

            case 'set':
                preg_match('/^set (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
                $val = is_numeric($matches["val"]) ? $matches["val"] : ($this->registers[$matches["val"]] ?? 0);
                $this->registers[$matches["reg"]] = $val;
                ++$this->eip;
                break;

            case 'add':
                preg_match('/^add (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
                if (empty($matches)) { var_dump($instruction); die(); }
                $val = is_numeric($matches["val"]) ? $matches["val"] : ($this->registers[$matches["val"]] ?? 0);
                $this->registers[$matches["reg"]] = ($this->registers[$matches["reg"]] ?? 0) + $val;
                ++$this->eip;
                break;

            case 'mul':
                preg_match('/^mul (?P<reg>([a-z])) (?P<val>([-0-9]+))$/s', $instruction, $matches);
                $this->registers[$matches["reg"]] = ($this->registers[$matches["reg"]] ?? 0) * $matches["val"];
                ++$this->eip;
                break;

            case 'mod':
                preg_match('/^mod (?P<reg>([a-z])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);
                $val = is_numeric($matches["val"]) ? $matches["val"] : ($this->registers[$matches["val"]] ?? 0);
                $this->registers[$matches["reg"]] = ($this->registers[$matches["reg"]] ?? 0) % $val;
                ++$this->eip;
                break;

            case 'rcv':
                preg_match('/^rcv (?P<reg>([a-z]))$/s', $instruction, $matches);

                if (empty($this->receiveBuffer)) {
                    return;
                }

                $val = array_shift($this->receiveBuffer);
                $this->registers[$matches["reg"]] = $val;

                ++$this->eip;
                break;

            case 'jgz':
                preg_match('/^jgz (?P<reg>([-a-z0-9])) (?P<val>([-a-z0-9]+))$/s', $instruction, $matches);

                $reg = is_numeric($matches["reg"]) ? $matches["reg"] : ($this->registers[$matches["reg"]] ?? 0);
                $val = is_numeric($matches["val"]) ? $matches["val"] : ($this->registers[$matches["val"]] ?? 0);

                if ($reg > 0) {
                    $this->eip += $val;
                } else {
                    ++$this->eip;
                }

                break;
            }
        }
    }

    public function isBlocked()
    {
        return substr($this->instructions[$this->eip], 0, 3) === "rcv" && empty($this->receiveBuffer);
    }

    public function isFinished()
    {
        return !isset($this->instructions[$this->eip]);
    }

    public function receive($value)
    {
        $this->receiveBuffer[] = $value;
    }
}

$programs = [
    new Program(0),
    new Program(1),
];
$prog1SendCount = 0;

function send($fromPid, $val) {
    global $prog1SendCount, $programs;
    if ($fromPid == 1) ++$prog1SendCount;

    $programs[($fromPid + 1) % 2]->receive($val);
}

$i = 0;
while (!(($programs[0]->isBlocked() && $programs[1]->isBlocked()) || ($programs[0]->isFinished() && $programs[1]->isFinished()))) {
    $programs[0]->run();
    $programs[1]->run();
    var_dump(++$i);
}

var_dump($prog1SendCount);
