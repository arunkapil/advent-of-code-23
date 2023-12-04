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

    $plays = explode(';', $plays);
    foreach ($plays as $play) {
        $blocks = explode(', ', trim($play));

        foreach ($blocks as $block) {
            list($count, $color) = explode(' ', $block);
            if ($cubes[$color] < $count) {
                $game = 'false';
            }
        }
    }

    if ($game !== 'false') {
        $superset[] = $game;
    }
}

d(array_sum($superset));



