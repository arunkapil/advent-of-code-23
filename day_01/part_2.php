<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');

$replacements = [
    'one' => 'o1e',
    'two' => 't2o',
    'three' => 't3ree',
    'four' => 'f4ur',
    'five' => 'f5ve',
    'six' => 's6x',
    'seven' => 'se7en',
    'eight' => 'e8ght',
    'nine' => 'n9ne',
];

$input = str_replace(array_keys($replacements), array_values($replacements), $input);


$lines = explode("\n", $input);
$cleaned = [];
foreach ($lines as $line) {
    $number = preg_replace("/[^0-9]/", "", $line);
    if (strlen($number) == 1) {
        $number .= $number;
    } elseif (strlen($number) > 2) {
        $number = substr($number, 0, 1) . substr($number, -1, 1);
    }

    $cleaned[] = $number;
}

d(array_sum($cleaned));
