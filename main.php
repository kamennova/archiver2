<?php

require_once "RunLengthCoder.php";

const INPUT_FILE = 'input.txt';
const OUTPUT_FILE = 'output.txt';

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
        $outname = isset($argv[3]) ? $argv[3] : null;

        $decoder = new RunLengthCoder();
        $decoder->decode($input, $outname);
    } else {
        echo "Wrong command" . "\n";
        return;
    }
}

read_command();