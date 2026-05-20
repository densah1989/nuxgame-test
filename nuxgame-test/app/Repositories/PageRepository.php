<?php

namespace App\Repositories;

use App\DTOs\PageDTO;
use App\Models\Page;

class PageRepository
{
    public function create(PageDTO $pageDTO): Page
    {

    }

    public function getByRoute(string $route): ?Page
    {

    }
}
