<?php

/**
 * @file
 * Runs the game of life.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use ColumbusPHP\GameOfLife\Grid;

$iterations = 1;
$filename = 'default.txt';
if (isset($argv[1])) {
    $filename = $argv[1];
}
if (isset($argv[2]) && filter_var($argv[2], FILTER_VALIDATE_INT) !== false && $argv[2] > 0) {
    $iterations = $argv[2];
}

$grid = Grid::fromFile(__DIR__ . '/../fixtures/' . $filename);
for ($i = 0; $i < $iterations; $i++) {
    $grid->tick();
    echo $grid;
}
