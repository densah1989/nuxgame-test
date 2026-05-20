<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\PageService;
use Exception;

class PageController extends Controller
{
    public function __construct(
        private readonly PageService $pageService,
    ) {
    }

    public function show(string $route): \Illuminate\View\View
    {
        $page = $this->pageService->getPage($route);

        abort_if(!$page || !$page->isActive(), 404, 'Page not found');

        return view('pages.show', [
            'userPage' => $page,
        ]);
    }

    /**
     * @throws Exception
     */
    public function regenerate(string $route): \Illuminate\Http\RedirectResponse
    {
        $page = $this->pageService->getPage($route);

        abort_if(!$page, 404, 'Page not found');

        $regeneratedPage = $this->pageService->regenerateRoute($page);

        return redirect()->route('pages.show', $regeneratedPage->route);
    }

    /**
     * @throws Exception
     */
    public function deactivate(string $route): \Illuminate\Http\RedirectResponse
    {
        $page = $this->pageService->getPage($route);

        abort_if(!$page, 404, 'Page not found');

        $this->pageService->deactivateRoute($page);

        return redirect()->route('home');
    }
}
