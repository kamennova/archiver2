<?php

class RunLengthCoder
{
    /**
     * @param $input
     * @param $output
     */
    function encode($input, $output)
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

    function decode($input, $outname = null)
    {
        $spl = new SplFileObject($input, 'r+');

        $nameline = $spl->fgets();
        $name = is_null($outname) ? substr($nameline, 0, strlen($nameline) - 1) : $outname;
        $output = new SplFileObject($name, 'w+');

        while (!$spl->eof()) {
            $line = $spl->fgets();
            $num = strlen($line);

            for ($i = 0; $i < $num; $i++) {
                $curr = $line[$i];

                if ($i + 1 < $num && $line[$i] == $line[$i + 1]) {
                    $i += 2;
                    $repeatNum = ord($line[$i]);

                    $decoded = str_repeat($curr, $repeatNum);
                    $output->fwrite($decoded);
                } else {
                    $output->fwrite($curr);
                }
            }
        }
    }
}