<?php

namespace App\Dtos;

class AuthDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?int $role_id = null,
    )
    {
    }

    public static function fromRequestRegister($request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            password: $request->password,
            role_id: $request->role_id,
        );
    }


}
