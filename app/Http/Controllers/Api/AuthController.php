<?php

namespace App\Http\Controllers\Api;

use App\Dtos\AuthDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ReqisterRequest;
use App\Repository\User\IUserRepository;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseAPI;
    public function __construct(
        private IUserRepository $userRepo
    ) {
    }

    public function register(ReqisterRequest $request)
    {
        try {
            $user = $this->userRepo->createUser(AuthDto::fromRequestRegister($request));
            $token = $user->createToken('auth_token')->accessToken;
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->success(
            'User created',
            [
                "user" => $user,
                "token" => $token
            ]
        );
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepo->getUserByEmail($request->email);

            if (!$user) {
                throw new \Exception('User not found');
            }

            if(!Hash::check($request->password, $user->password)) {
                throw new \Exception('User not found');
            }

            match ($user->role_id) {
                1 => $token = $user->createToken('AdminToken', ['admin'])->accessToken,
                default => $token = $user->createToken('UserToken', ['user'])->accessToken,
            };

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }

        return $this->success(
            'User created',
            [
                "user" => $user,
                "token" => $token
            ]
        );
    }

}
