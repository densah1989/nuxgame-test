<?php

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;

class PageService
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {
    }

    public function generatePage(int $userId)
    {

    }

    public function regenerateRoute(Page $page)
    {

    }

    public function deactivateRoute(Page $page)
    {

    }


}
