<?php

namespace ColumbusPHP\GameOfLife;

class Cell
{
    protected int $x;
    protected int $y;
    protected bool $alive;

    public function __construct(int $x, int $y, bool $hasLife = false)
    {
        $this->x = $x;
        $this->y = $y;
        $this->alive = $hasLife;
    }

    public function isAlive(): bool
    {
        return $this->alive;
    }

    public function isDead(): bool
    {
        return !$this->alive;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function resurrect() :void
    {
        $this->alive = true;
    }
}
