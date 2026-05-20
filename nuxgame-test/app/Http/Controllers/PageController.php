<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\RegisterRequest;
use App\PaymentProviders\DTOs\CreatePaymentDTO;
use App\Services\PageService;
use App\Services\PaymentService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function __construct(
        private readonly PageService $pageService,
    ) {
    }

    public function show(string $route): JsonResponse
    {
        $payment = $this->userService->create(
            CreatePaymentDTO::fromRequest($request)
        );

        return response()->json([
            'id' => $payment->id,
            'provider' => $payment->provider,
            'external_id' => $payment->external_id,
            'status' => $payment->status,
            'payment_url' => $payment->payment_url,
        ], 201);
    }

    public function regenerate(string $route): JsonResponse
    {
        $payment = $this->userService->create(
            CreatePaymentDTO::fromRequest($request)
        );

        return response()->json([
            'id' => $payment->id,
            'provider' => $payment->provider,
            'external_id' => $payment->external_id,
            'status' => $payment->status,
            'payment_url' => $payment->payment_url,
        ], 201);
    }

    public function deactivate(string $route): JsonResponse
    {
        $payment = $this->userService->create(
            CreatePaymentDTO::fromRequest($request)
        );

        return response()->json([
            'id' => $payment->id,
            'provider' => $payment->provider,
            'external_id' => $payment->external_id,
            'status' => $payment->status,
            'payment_url' => $payment->payment_url,
        ], 201);
    }
}
