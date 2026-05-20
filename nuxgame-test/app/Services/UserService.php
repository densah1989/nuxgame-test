<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function register(UserDTO $userDTO)
    {

    }
}
