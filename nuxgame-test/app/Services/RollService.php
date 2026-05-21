<?php

namespace App\Services;

use App\DTOs\RollDTO;
use App\Models\User;
use App\Repositories\RollRepository;
use App\ValueObjects\RollResultVO;
use Carbon\Carbon;
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

        $this->rollRepository->create(
            new RollDTO(
                userId: $user->id,
                number: $randomNumber,
                createdAt: new Carbon,
            )
        );

        return new RollResultVO(
            number: $randomNumber,
            isWin: $this->isWin($randomNumber),
            prize: $this->calculatePrize($randomNumber),
        );
    }

    public function calculatePrize(int $win): float
    {
        if (!$this->isWin($win)) {
            return 0.0;
        }

        if ($win > 900) {
            return round($win * 0.7, 2);
        }

        if ($win > 600) {
            return round($win * 0.5, 2);
        }

        if ($win > 300) {
            return round($win * 0.3, 2);
        }

        return round($win * 0.1, 2);
    }

    public function isWin(int $win): bool
    {
        return $win % 2 === 0;
    }

    public function getHistory(int $userId): Collection
    {
        return $this->rollRepository->getLastThreeByUserId($userId);
    }
}
