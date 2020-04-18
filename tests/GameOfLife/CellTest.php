<?php

namespace ColumbusPHP\Tests\GameOfLife;

use ColumbusPHP\GameOfLife\Cell;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    public function testExists(): void
    {
        $cell = new Cell(0, 0);
        $this->assertNotNull($cell);
    }

    public function testIsDeadByDefault(): void
    {
        $cell = new Cell(0, 0);
        $this->assertTrue($cell->isDead());
    }

    /**
     * @param int $x
     * @param int $expected
     * @dataProvider coordinateProvider
     */
    public function testHasXCoordinate(int $x, int $expected): void
    {
        $cell = new Cell($x, 0);
        $this->assertEquals($expected, $cell->x());
    }

    /**
     * @param int $y
     * @param int $expected
     * @dataProvider coordinateProvider
     */
    public function testHasYCoordinate(int $y, int $expected): void
    {
        $cell = new Cell(0, $y);
        $this->assertEquals($expected, $cell->y());
    }

    public function testIsAlive(): void
    {
        $cell = new Cell(0, 0, true);
        $this->assertTrue($cell->isAlive());
    }

    public function coordinateProvider(): array
    {
        return [
          [0, 0],
          [1, 1],
          [2, 2],
          [3, 3],
        ];
    }
}
