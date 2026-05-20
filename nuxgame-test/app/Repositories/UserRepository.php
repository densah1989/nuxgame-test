<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Models\User;

class UserRepository
{
    public function create(UserDTO $userDTO): User
    {
        return User::create([
            'username' => $userDTO->getUsername(),
            'phone_number' => $userDTO->getPhoneNumber(),
            'created_at' => $userDTO->getCreatedAt(),
            'updated_at' => $userDTO->getUpdatedAt(),
        ]);
    }
}
