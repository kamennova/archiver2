<?php

class RunLengthCoder
{
    function encode($input, $output)
    {
        $this->encodeFunc($input, $output);
    }

    /**
     * @param $input
     * @param $output
     */
    function encodeFunc($input, $output)
    {
        $spl = new SplFileObject($input, 'r+');

        $output = new SplFileObject($output, 'w+');
        $output->fwrite($input . PHP_EOL);

        while (!$spl->eof()) {

            $line = $spl->fgets();
            $prev = null;

            for ($i = 0, $num = strlen($line); $i < $num; $i++) {
                $curr = $line[$i];

                if (($prev !== null) && ($curr === $prev)) {
                    $output->fwrite($curr);
                    $repeatNum = 2;

                    for ($a = $i + 1; $a < $num; $a++) {
                        if ($line[$a] != $curr) break;
                        $repeatNum++;
                    }

                    $i = $a - 1;
                    $output->fwrite(chr($repeatNum));

                } else {
                    $output->fwrite($curr);
                }

                $prev = $curr;
            }
        }
    }

//    ---

    function decode($input)
    {
        $this->decodeFunc($input);
    }

    function decodeFunc($input)
    {
        $spl = new SplFileObject($input, 'r+');
        $nameline = $spl->fgets();
        $name = substr($nameline, 0, strlen($nameline) - 1);

        $output = new SplFileObject($name, 'w+');

        while (!$spl->eof()) {

            $line = $spl->fgets();

            for ($i = 0, $num = strlen($line); $i < $num; $i++) {
                $curr = $line[$i];
                echo $curr;

                if($line[$i] == $line[$i+1]){
                    $repeatNum = ord($line[++$i]);
                    $line = str_repeat($curr, $repeatNum);

                    $output->fwrite($line);
                }

            }
        }
    }
}