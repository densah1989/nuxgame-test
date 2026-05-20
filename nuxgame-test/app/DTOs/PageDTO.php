<?php

namespace App\DTOs;

use Carbon\Carbon;

class PageDTO
{
    public function __construct(
        private readonly int $userId,
        private readonly string $route,
        private readonly Carbon $expiresAt,
        private readonly Carbon $createdAt,
        private readonly Carbon $updatedAt,
        private readonly ?Carbon $deletedAt = null,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->deletedAt;
    }
}
