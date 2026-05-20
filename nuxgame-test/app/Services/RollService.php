<?php

namespace App\Services;

use App\Models\Page;
use App\Models\User;
use App\Repositories\RollRepository;
use Illuminate\Support\Collection;

class RollService
{
    public function __construct(
        private readonly RollRepository $rollRepository,
    ) {
    }

    public function roll(User $user)
    {

    }

    public function calculatePrize(int $win): int
    {

    }

    public function isWin(int $win): bool
    {

    }

    public function getHistory(int $userId): Collection
    {

    }
}
