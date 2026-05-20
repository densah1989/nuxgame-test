<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Roll;
use App\Services\PageService;
use App\Services\RollService;

class RollController extends Controller
{
    public function __construct(
        private readonly RollService $rollService,
        private readonly PageService $pageService,
    ) {
    }

    public function imFeelingLucky(string $route
    ): \Illuminate\View\View {
        $page = $this->pageService->getPage($route);

        abort_if(!$page, 404, 'Page not found');

        $roll = $this->rollService->roll($page->user);

        return view('pages.result', [
            'number' => $roll->getNumber(),
            'win' => $roll->isWin(),
            'prize' => $roll->getPrize(),
        ]);
    }

    public function history(string $route
    ): \Illuminate\View\View {
        $page = $this->pageService->getPage($route);

        abort_if(!$page, 404, 'Page not found');

        $history = $this->rollService->getHistory($page->user_id);

        return view('pages.history', [
            'rolls' => $history
                ->map(fn(Roll $roll) => [
                    'number' => $roll->number,
                    'win' => $this->rollService->isWin($roll->number),
                    'prize' => $this->rollService->calculatePrize($roll->number),
                    'created_at' => $roll->created_at,
                ]),
        ]);
    }
}
