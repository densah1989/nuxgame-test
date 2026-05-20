<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\PageService;
use Exception;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function __construct(
        private readonly PageService $pageService,
    ) {
    }

    public function show(string $route): JsonResponse
    {
        $page = $this->pageService->getPage($route);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
            ], 404);
        }

        return response()->json([
            'page' => $page,
        ], 201);
    }

    /**
     * @throws Exception
     */
    public function regenerate(string $route): JsonResponse
    {
        $page = $this->pageService->getPage($route);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
            ], 404);
        }

        $regeneratedPage = $this->pageService->regenerateRoute($page);

        return response()->json([
            'page' => $regeneratedPage,
        ], 201);
    }

    /**
     * @throws Exception
     */
    public function deactivate(string $route): JsonResponse
    {
        $page = $this->pageService->getPage($route);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
            ], 404);
        }

        return response()->json([
            'success' => $this->pageService->deactivateRoute($page),
        ], 201);
    }
}
