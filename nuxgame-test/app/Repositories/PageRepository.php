<?php

namespace App\Repositories;

use App\DTOs\PageDTO;
use App\Models\Page;

class PageRepository
{
    public function create(PageDTO $pageDTO): Page
    {
        return Page::create([
            'user_id' => $pageDTO->getUserId(),
            'route' => $pageDTO->getRoute(),
            'expires_at' => $pageDTO->getExpiresAt(),
            'created_at' => $pageDTO->getCreatedAt(),
            'updated_at' => $pageDTO->getUpdatedAt(),
        ]);
    }

    public function getByRoute(string $route): ?Page
    {
        return Page::with('user')
                   ->where('route', $route)
                   ->first();
    }
}
