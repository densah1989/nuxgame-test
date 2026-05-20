<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function register(UserDTO $userDTO): User
    {
        return $this->userRepository->create($userDTO);
    }
}
