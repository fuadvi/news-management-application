<?php

namespace App\Http\Controllers\Api;

use App\Dtos\AuthDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReqisterRequest;
use App\Repository\User\IUserRepository;
use App\Traits\ResponseAPI;

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

}
