<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\PageService;
use App\Services\RollService;
use Illuminate\Http\JsonResponse;

class RollController extends Controller
{
    public function __construct(
        private readonly RollService $rollService,
        private readonly PageService $pageService,
    ) {
    }

    public function imFeelingLucky(string $route): JsonResponse
    {
        $page = $this->pageService->getPage($route);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
            ], 404);
        }

        $roll = $this->rollService->roll($page->user);

        return response()->json([
            'number' => $roll->getNumber(),
            'isWin' => $roll->isWin(),
            'prize' => $roll->getPrize(),
        ], 201);
    }

    public function history(string $route): JsonResponse
    {
        $page = $this->pageService->getPage($route);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
            ], 404);
        }

        $history = $this->rollService->getHistory($page->user_id);

        return response()->json([
            'history' => $history,
        ], 201);
    }
}
