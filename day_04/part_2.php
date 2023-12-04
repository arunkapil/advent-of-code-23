<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_replace(['  ', ':'], [' ', '|'], $input); // adjust formatting for ease of use
$lines = explode("\n", $input);

$cleaned = [];
$cards = [];
foreach ($lines as $line) {
    $count = 0;

    $numbers = preg_replace("/[^0-9 |]/", "", $line);
    list($card, $winners, $scratched) = explode('|', $numbers);

    $card = (integer) trim($card);
    $winners = trim($winners);
    $scratched = trim($scratched);

    $numbers_winning = explode(' ', $winners);
    $numbers_scratch = explode(' ', $scratched);

    foreach ($numbers_scratch as $num) {
        if (in_array($num, $numbers_winning)) {
            $count++;
        }
    }

    if ($count > 0) {
        // $result[trim($game)] = 1 + (pow(2, $count - 1) - 1);
    }

    $cards[] = $count;
}

$card_count = array_fill(0, count($cards), 1);
foreach ($cards as $i => $matches) {
    for ($j = 0; $j < $card_count[$i]; $j++) {
        for ($k = 0; $k < $matches; $k++) {
            if (isset($card_count[$i + 1 + $k])) {
                $card_count[$i + 1 + $k]++;
            }
        }
    }
}

d(array_sum($card_count));

