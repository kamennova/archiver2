<?php

require_once "RunLengthCoder.php";

const INPUT_FILE = 'input.txt';
const OUTPUT_FILE = 'output.txt';

var_dump($argv);

function read_command()
{
    global $argv;

    if ($argv[1] === 'compress') {
        $input = $argv[2];
        $output = $argv[3];

        $decoder = new RunLengthCoder();
        $decoder->encode($input, $output);

    } else if ($argv[1] === 'extract') {
        $input = $argv[2];

        $decoder = new RunLengthCoder();
        $decoder->decode($input);
    } else {
        echo "Wrong command" . "\n";
        return;
    }
}

read_command();