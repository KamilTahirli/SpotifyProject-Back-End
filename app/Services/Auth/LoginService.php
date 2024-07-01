<?php

namespace App\Services\Auth;

use App\Constants\TokenConstant;
use App\Dto\Auth\LoginDto;
use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginService extends Service
{


    /**
     * @param LoginDto $dto
     * @return array
     */
    public function login(LoginDto $dto): array
    {
        $user = User::query()->where('email', $dto->getEmail())->first();

        if (!$user || !Hash::check($dto->getPassword(), $user->password)) {
            return $this->responseBuilder(Response::HTTP_UNPROCESSABLE_ENTITY, "Email ve ya parol sehvdir");
        }

        $data = [
            "user" => $user,
            "token" => $user->createToken(TokenConstant::TOKEN_NAME)->plainTextToken
        ];
        return $this->responseBuilder(Response::HTTP_OK, "Giriş uğurludur", $data);
    }

}