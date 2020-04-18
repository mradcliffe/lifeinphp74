<?php

/**
 * @file
 * Runs the game of life.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use ColumbusPHP\GameOfLife\Grid;

$argv[1] ??= 'default.txt';
$argv[2] ??= 1;

$grid = Grid::fromFile(__DIR__ . '/../fixtures/' . $argv[1]);
for ($i = 0; $i < $argv[2]; $i++) {
    $grid->tick();
    echo $grid;
}
