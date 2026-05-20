<?php

namespace App\Repositories;

use App\DTOs\RollDTO;
use App\Models\Roll;
use Illuminate\Support\Collection;

class RollRepository
{
    public function create(RollDTO $rollDTO): Roll
    {
        return Roll::create([
            'user_id' => $rollDTO->getUserId(),
            'number' => $rollDTO->getNumber(),
            'created_at' => $rollDTO->getCreatedAt(),
        ]);
    }

    public function getLastThreeByUserId(int $userId): Collection
    {
        return Roll::where('user_id', $userId)
                   ->latest()
                   ->take(3)
                   ->get();
    }
}
