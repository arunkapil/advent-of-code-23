<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$lines = explode("\n", $input);

$number_series = [];
$symbol_series = [];
foreach ($lines as $line_number => $line) {
    $number_relations = [];
    $symbol_relations = [];

    // Every line must terminate in a dot
    $line .= '.';

    // Clear the trash
    $entries = str_split($line);

    // Find related numbers per line and save them
    $cache = [];
    foreach ($entries as $position => $char) {
        if (is_numeric($char)) {
            $cache[$position] = $char;
        } else {
            foreach ($cache as $i => $n) {
                $number_relations[$i] = implode('', $cache);
            }
            $cache = []; // reset cache

            // save valid symbols
            if ($char !== '.') {
                $symbol_relations[$position] = $char;
            }
        }
    }

    $number_series[$line_number] = $number_relations;
    $symbol_series[$line_number] = $symbol_relations;
}

// Remove empty symbol pages
$symbol_series = array_filter($symbol_series);

$result = [];
foreach ($symbol_series as $page_number => $content) {

    foreach ($content as $position => $symbol) {
        $previous = $current = $next = [];

        // Previous Page
        if (array_key_exists($page_number - 1, $number_series)) {
            $previous = searchPageForMatch(
                $number_series[$page_number - 1],
                [
                    $position - 1,
                    $position,
                    $position + 1,
                ]
            );
        }

        // Current Page
        $current = searchPageForMatch(
            $number_series[$page_number],
            [
                $position - 1,
                $position + 1,
            ]
        );

        // // Previous Page
        if (array_key_exists($page_number + 1, $number_series)) {
            $next = searchPageForMatch(
                $number_series[$page_number + 1],
                [
                    $position - 1,
                    $position,
                    $position + 1,
                ]
            );
        }

        // $result["{$page_number}.{$position}"] = $previous + $current + $next;
        $result["{$page_number}.{$position}"] = array_sum($previous) + array_sum($current) + array_sum($next);
    }
}

d(array_sum($result));

function searchPageForMatch(array $series, array $positions): array {
    $values = [];
    foreach ($positions as $position) {
        if (array_key_exists($position, $series)) {
            $value = $series[$position];
            $values[$value] = true;
        }
    }

    return array_keys($values);
}



