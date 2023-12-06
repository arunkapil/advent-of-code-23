<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_replace(['seeds:'], [''], $input); // adjust formatting for ease of use
$blocks = explode("\n\n", trim($input));

$seeds = array_map('intval', explode(" ", trim(array_shift($blocks))));

foreach ($blocks as &$page) {
    $lines = explode("\n", $page);
    $type = array_shift($lines);

    $list = [];
    foreach ($lines as $line) {
        $list[] = explode(" ", trim($line));
    }
    $page = [$type, $list];
}
unset($page); // break connection

$ranges = [];
for ($i = 0; $i < count($seeds); $i++) {
    $ranges[] = [
        $seeds[$i],
        $seeds[$i + 1],
    ];

    ++$i;
}

foreach ($blocks as &$page) {
    list($type, $maps) = $page;

    $inc = [];
    foreach ($maps as $line) {
        $exc = [];
        list($destination, $source, $length) = $line;

        foreach ($ranges as $range) {
            list($position, $position_length) = $range;

            if (
                ($position + $position_length < $source)
                || ($position >= $source + $length)
            ) {
                $exc[] = [
                    $position,
                    $position_length,
                ];
            }
            else {
                $max = max($position, $source);

                $inc[] = [
                    $destination + $max - $source,
                    min($position + $position_length, $source + $length) - $max,
                ];

                if ($position < $source) {
                    $exc[] = [
                        $position,
                        $source - $position,
                    ];
                }

                if ($position + $position_length > $source + $length) {
                    $exc[] = [
                        $source + $length,
                        $position + $position_length - $source - $length,
                    ];
                }
            }
        }

        $ranges = $exc;
    }

    $ranges = array_merge($inc, $ranges);
}

$minimum = min(array_map(function (array $range = []) {
    return $range[0];
}, $ranges));

d($minimum);
