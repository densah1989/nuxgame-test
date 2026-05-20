<?php

namespace App\Services;

use App\DTOs\PageDTO;
use App\Models\Page;
use App\Models\User;
use App\Repositories\PageRepository;
use Carbon\Carbon;
use Exception;

class PageService
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {
    }

    public function getPage(string $route): ?Page
    {
        return $this->pageRepository->getByRoute($route);
    }

    public function generatePage(User $user): Page
    {
        $route = $this->generateRouteValue($user);

        $now = new Carbon;

        return $this->pageRepository->create(
            new PageDTO(
                userId: $user->id,
                route: $route,
                expiresAt: $now->addDays(7),
                createdAt: $now,
                updatedAt: $now
            )
        );
    }

    public function regenerateRoute(Page $page): ?Page
    {
        if (!$page->relationLoaded('user')) {
            $page->load('user');
        }

        do {
            $newRoute = $this->generateRouteValue($page->user);
        } while ($newRoute === $page->route);

        try {
            $page->update([
                'route' => $newRoute,
                'updated_at' => new Carbon,
            ]);
        } catch (Exception $e) {
            throw new Exception('Failed to deactivate route');
        }

        return $this->pageRepository->getByRoute($newRoute);
    }

    /**
     * @throws Exception
     */
    public function deactivateRoute(Page $page): true
    {
        try {
            $page->update([
                'deleted_at' => new Carbon,
            ]);
        } catch (Exception $e) {
            throw new Exception('Failed to deactivate route');
        }

        return true;
    }

    private function generateRouteValue(User $user): string
    {
        return md5($user->username . rand(1000, 9999) . $user->phone_number);
    }
}
