<?php

namespace App\Repository\User;

use App\Dtos\AuthDto;
use App\Models\User;

class UserRepository implements IUserRepository
{
    public function __construct(
        private User $user
    )
    {
    }


    public function getUserByEmail(string $email): User
    {
        return $this->user->where('email', $email)->first();
    }

    public function createUser(AuthDto $dto): User
    {
        return $this->user->create(array_filter((array)$dto));
    }
}
