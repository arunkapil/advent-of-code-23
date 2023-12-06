<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_replace(['Time:        ', 'Distance:   ', "\n"], ['', '', "|"], $input); // adjust formatting for ease of use
$input = preg_replace('/\s+/', ' ', $input); // adjust formatting for ease of use
$lines = explode("|", $input);

// part 1
d(calculateWays(
    explode(' ', $lines[0]),
    explode(' ', $lines[1])
));

// part 2
d(calculateWays(
    [str_replace(' ', '', $lines[0])],
    [str_replace(' ', '', $lines[1])]
));

function calculateWays($times, $distances): int {
    $count = 1;

    for ($i = 0; $i < count($times); $i++) {
        $arr = [];
        $index = 0;
        for ($j = 1; $j < $times[$i]; $j++) {
            if ((($times[$i] - $j) * ++$index) > $distances[$i]) {
                array_push($arr, $j);
            }
        }
        $count *= count($arr);
    }

    return $count;
}
