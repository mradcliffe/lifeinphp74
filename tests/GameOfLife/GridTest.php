<?php

namespace ColumbusPHP\Tests\GameOfLife;

use ColumbusPHP\GameOfLife\Cell;
use ColumbusPHP\GameOfLife\Grid;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testGridExists(): void
    {
        $grid = new Grid();
        $this->assertInstanceOf('\ColumbusPHP\GameOfLife\Grid', $grid);
    }

    public function testGridSizeOf(): void
    {
        $grid = new Grid(4, 8);
        $this->assertEquals(32, $grid->sizeof());
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param int $x
     * @param int $y
     * @param Cell $expected
     * @dataProvider cellProvider
     */
    public function testGridAt(int $rows, int $columns, int $x, int $y, Cell $expected): void
    {
        $grid = new Grid($rows, $columns);
        $this->assertEquals($expected, $grid->at($x, $y));
    }

    /**
     * @param int $rows
     * @param int $columns
     * @param array $expected
     * @dataProvider cellsProvider
     */
    public function testGridCells(int $rows, int $columns, array $expected): void
    {
        $grid = new Grid($rows, $columns);
        $this->assertEquals($expected, $grid->getCells());
    }

    public function testParseGridFromFile(): void
    {
        $grid = Grid::fromFile(__DIR__ . '/../../fixtures/default.txt');
        $this->assertEquals(32, $grid->sizeof());
        $aliveCells = array_filter($grid->getCells(), fn($cell) => $cell->isAlive());
        $this->assertCount(3, $aliveCells);
    }

    /**
     * @param int $x
     * @param int $y
     * @param bool $expected
     * @dataProvider cellPredictorProvider
     */
    public function testGridCellWillLive(int $x, int $y, bool $expected): void
    {
        $grid = Grid::fromFile(__DIR__ . '/../../fixtures/default.txt');
        $cell = $grid->at($x, $y);
        $this->assertEquals($expected, $grid->cellWillLive($cell));
    }

    public function cellProvider(): array
    {
        return [
            [
                1,
                1,
                0,
                0,
                new Cell(0, 0),
            ],
            [
                1,
                2,
                0,
                1,
                new Cell(0, 1),
            ],
        ];
    }

    public function cellsProvider(): array
    {
        return [
            [
                1, 1, [new Cell(0, 0)],
            ],
            [
                1, 2, [new Cell(0, 0), new Cell(0, 1)],
            ],
            [
                2, 2, [
                  new Cell(0, 0),
                  new Cell(0, 1),
                  new Cell(1, 0),
                  new Cell(1, 1),
                ],
            ],
        ];
    }

    public function cellPredictorProvider(): array
    {
        return [
            [0, 0, false],
            [1, 3, true],
            [1, 4, true],
            [1, 5, false],
            [2, 3, true],
            [2, 4, true],
            [2, 5, false],
            [3, 3, false],
            [3, 4, false],
        ];
    }
}
