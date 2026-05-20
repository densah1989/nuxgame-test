<?php

namespace App\DTOs;

use Carbon\Carbon;

class RollDTO
{
    public function __construct(
        private readonly int $userId,
        private readonly int $number,
        private readonly Carbon $createdAt,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
