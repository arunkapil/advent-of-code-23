<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_replace(['  ', ':'], [' ', '|'], $input); // adjust formatting for ease of use
$lines = explode("\n", $input);

$cleaned = [];
foreach ($lines as $line) {
    $count = 0;

    $numbers = preg_replace("/[^0-9 |]/", "", $line);
    list($game, $winners, $scratched) = explode('|', $numbers);

    $numbers_winning = explode(' ', trim($winners));
    $numbers_scratch = explode(' ', trim($scratched));

    foreach ($numbers_scratch as $num) {
        if (in_array($num, $numbers_winning)) {
            $count++;
        }
    }

    if ($count > 0) {
        $result[trim($game)] = 1 + (pow(2, $count - 1) - 1);
    }
}

d(array_sum($result));
