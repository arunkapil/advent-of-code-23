<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_replace(['seeds:'], [''], $input); // adjust formatting for ease of use
$blocks = explode("\n\n", trim($input));

$seeds = array_map('intval', explode(" ", trim(array_shift($blocks))));

$mapped = array_map('mapBlocks', $blocks);

$minimum = min(array_map(function ($seed) use ($mapped) {
    foreach ($mapped as $map) {
        foreach ($map as $item) {
            if ($seed >= $item['ran'][0] && $seed < $item['ran'][1]) {
                $seed += $item['off'];
                break;
            }
        }
    }
    return $seed;
}, $seeds));

d($minimum);

function mapBlocks($input) {
    $result = [];
    $lines = explode("\n", $input);

    array_shift($lines);
    foreach ($lines as $line) {
        $ns = array_map('intval', explode(" ", $line));
        $result[] = [
            'ran' => [
                $ns[1],
                $ns[1] + $ns[2],
            ],
            'off' => $ns[0] - $ns[1],
        ];
    }

    return $result;
}
