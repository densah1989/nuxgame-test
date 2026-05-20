<?php

namespace App\DTOs;

use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;

class UserDTO
{
    public function __construct(
        private readonly string $username,
        private readonly string $phoneNumber,
        private readonly Carbon $createdAt,
        private readonly Carbon $updatedAt,
    ) {
    }

    public static function fromRequest(RegisterRequest $request): self
    {
        $now = new Carbon;

        return new self(
            username: $request->input('username'),
            phoneNumber: (float)$request->input('phone_number'),
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
