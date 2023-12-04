<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$lines = explode("\n", $input);

$cubes = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

$superset = [];
foreach ($lines as $line) {
    list($game, $plays) = explode(': ', $line);
    $game = preg_replace("/[^0-9]/", "", $game);
    $superset[$game] = [];

    $plays = explode(';', $plays);
    foreach ($plays as $play) {
        $blocks = explode(', ', trim($play));

        foreach ($blocks as $block) {
            list($count, $color) = explode(' ', $block);
            if (!array_key_exists($color, $superset[$game])) {
                $superset[$game][$color] = $count;
            } elseif ($superset[$game][$color] < $count) {
                $superset[$game][$color] = $count;
            }
        }
    }

    $superset[$game] = array_product($superset[$game]);
}

d(array_sum($superset));



