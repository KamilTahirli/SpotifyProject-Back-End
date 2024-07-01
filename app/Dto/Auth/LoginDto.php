<?php

namespace App\Dto\Auth;

use App\Http\Requests\Auth\LoginRequest;

class LoginDto
{

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @param LoginRequest $request
     */
    public function __construct(LoginRequest $request)
    {
        $this->email = $request->email;
        $this->password = $request->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}