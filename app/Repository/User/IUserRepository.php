<?php

namespace App\Repository\User;


use App\Dtos\AuthDto;
use App\Models\User;

interface IUserRepository
{
    public function getUserByEmail(string $email): User;
    public function createUser(AuthDto $dto): User;

}
