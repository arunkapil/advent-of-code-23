<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
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
