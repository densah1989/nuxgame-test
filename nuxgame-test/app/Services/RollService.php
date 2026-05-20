<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\RollRepository;
use App\ValueObjects\RollResultVO;
use Illuminate\Support\Collection;

class RollService
{
    public function __construct(
        private readonly RollRepository $rollRepository,
    ) {
    }

    public function roll(User $user): RollResultVO
    {
        $randomNumber = rand(1, 1000);

        return new RollResultVO(
            number: $randomNumber,
            isWin: $this->isWin($randomNumber),
            prize: $this->calculatePrize($randomNumber),
        );
    }

    private function calculatePrize(int $win): int
    {
        if ($win > 900) {
            return (int)round($win * 0.7);
        }

        if ($win > 600) {
            return (int)round($win * 0.5);
        }

        if ($win > 300) {
            return (int)round($win * 0.3);
        }

        return (int)round($win * 0.1);
    }

    private function isWin(int $win): bool
    {
        return $win % 2 === 0;
    }

    public function getHistory(int $userId): Collection
    {
        return $this->rollRepository->getLastThreeByUserId($userId);
    }
}
