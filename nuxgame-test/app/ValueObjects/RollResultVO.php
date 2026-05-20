<?php

namespace App\ValueObjects;

class RollResultVO
{
    public function __construct(
        private readonly int $number,
        private readonly bool $isWin,
        private readonly int $prize,
    ) {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function isWin(): bool
    {
        return $this->isWin;
    }

    public function getPrize(): int
    {
        return $this->prize;
    }
}
