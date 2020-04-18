<?php

namespace ColumbusPHP\GameOfLife;

use InvalidArgumentException;

class Grid
{
    protected int $generation = 1;
    protected int $rows;
    protected int $columns;
    protected array $cells = [];

    public function __construct(int $rows = 0, int $columns = 0)
    {
        $this->rows = $rows;
        $this->columns = $columns;

        for ($x = 0; $x < $rows; $x++) {
            for ($y = 0; $y < $columns; $y++) {
                $this->cells[] = new Cell($x, $y);
            }
        }
    }

    public static function fromFile(string $filepath): self
    {
        if (realpath($filepath)) {
            $contents = file_get_contents($filepath);
            preg_match_all('/^[\.\*]+$/m', $contents, $gridMatches);
            if (!empty($gridMatches)) {
                $rows = count($gridMatches[0]);
                $columns = strlen($gridMatches[0][0]);
                $instance = new static($rows, $columns);

                foreach ($gridMatches[0] as $x => $row) {
                    for ($y = 0; $y < strlen($row); $y++) {
                        if ($row[$y] === '*') {
                            $instance->at($x, $y)->resurrect();
                        }
                    }
                }

                return $instance;
            }
        }

        throw new InvalidArgumentException('File not found');
    }

    public function sizeof(): int
    {
        return $this->rows * $this->columns;
    }

    public function at(int $x, int $y): ?Cell
    {
        return array_reduce($this->cells, fn($result, $cell) => $result === null && $cell->x() === $x && $cell->y() === $y ? $cell : $result, null);
    }

    public function getCells(): array
    {
        return $this->cells;
    }

    public function cellWillLive(Cell $cell): bool
    {
        $neighbors = $this->getNeighborsOf($cell);
        $aliveNeighbors = array_filter($neighbors, fn($neighbor) => $neighbor->isAlive());
        $count = count($aliveNeighbors);

        if ($cell->isDead() && $count !== 3) {
            return false;
        }
        if ($count < 2) {
            return false;
        }
        if ($count > 3) {
            return false;
        }

        return true;
    }

    public function tick(): void
    {
        $this->generation = $this->generation + 1;
        $this->cells = array_map(fn(Cell $cell) => new Cell($cell->x(), $cell->y(), $this->cellWillLive($cell)), $this->cells);
    }

    public function __toString()
    {
        $out = 'Generation ' . $this->generation . ":\n";
        $out .= $this->rows . ' ' . $this->columns . "\n";
        for ($x = 0; $x < $this->rows; $x++) {
            $cells = array_filter($this->cells, fn(Cell $cell) => $cell->x() === $x);
            $out .= array_reduce($cells, fn($result, Cell $cell) => $cell->isAlive() ? "$result*" : "$result.", '') . "\n";
        }

        return $out;
    }

    protected function getNeighborsOf(Cell $cell): array
    {
        $neighbors = [
            $this->at($cell->x() - 1, $cell->y() - 1),
            $this->at($cell->x() - 1, $cell->y()),
            $this->at($cell->x() - 1, $cell->y() + 1),
            $this->at($cell->x(), $cell->y() - 1),
            $this->at($cell->x(), $cell->y() + 1),
            $this->at($cell->x() + 1, $cell->y() - 1),
            $this->at($cell->x() + 1, $cell->y()),
            $this->at($cell->x() + 1, $cell->y() + 1),
        ];

        return array_filter($neighbors, fn($neighbor) => $neighbor !== null);
    }
}
