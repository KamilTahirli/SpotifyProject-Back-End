<?php

namespace App\Dto\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterDto
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
     * @var string
     */
    private string $full_name;

    /**
     * @param RegisterRequest $request
     */
    public function __construct(RegisterRequest $request)
    {
        $this->email = $request->email;
        $this->password = $request->password;
        $this->full_name = $request->full_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFullName(): string
    {
        return $this->full_name;
    }
}