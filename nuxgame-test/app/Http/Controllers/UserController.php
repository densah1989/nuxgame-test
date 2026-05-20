<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Http\Requests\RegisterRequest;
use App\Services\PageService;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PageService $pageService,
    ) {
    }

    public function register(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = $this->userService->register(
            UserDTO::fromRequest($request)
        );

        $page = $this->pageService->generatePage(user: $user);

        return redirect()->route('pages.show', $page->route);
    }
}
