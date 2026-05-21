<?php

namespace Tests\Unit;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private MockInterface $userRepository;
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->service = new UserService($this->userRepository);
    }

    public function test_register_calls_repository_with_dto(): void
    {
        $dto = new UserDTO(username: 'John', phoneNumber: '+1234567890');

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->with($dto)
            ->andReturn(new User());

        $this->service->register($dto);
    }

    public function test_register_returns_user_instance(): void
    {
        $dto = new UserDTO(username: 'Jane', phoneNumber: '+9876543210');

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn(new User());

        $result = $this->service->register($dto);

        $this->assertInstanceOf(User::class, $result);
    }

    public function test_register_passes_dto_data_unchanged(): void
    {
        $dto = new UserDTO(username: 'Bob', phoneNumber: '+1112223333');
        $captured = null;

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->withArgs(function (UserDTO $received) use (&$captured) {
                $captured = $received;

                return true;
            })
            ->andReturn(new User());

        $this->service->register($dto);

        $this->assertSame('Bob', $captured->getUsername());
        $this->assertSame('+1112223333', $captured->getPhoneNumber());
    }
}
