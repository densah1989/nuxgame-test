<?php

namespace App\Repositories;

use App\DTOs\RollDTO;
use App\Models\Roll;
use Illuminate\Support\Collection;

class RollRepository
{
    public function create(RollDTO $rollDTO): Roll
    {

    }

    public function getLastThreeByUserId(int $userId): Collection
    {

    }
}
