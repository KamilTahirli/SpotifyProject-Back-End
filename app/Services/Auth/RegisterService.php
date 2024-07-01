<?php

namespace App\Services\Auth;

use App\Constants\TokenConstant;
use App\Dto\Auth\RegisterDto;
use App\Models\User;
use App\Services\Front\MusicService;
use App\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class RegisterService extends Service
{

    /**
     * @param RegisterDto $dto
     * @return array
     */
    public function register(RegisterDto $dto): array
    {
        $user = User::query()->create([
            'full_name' => $dto->getFullName(),
            'email' => $dto->getEmail(),
            'password' => bcrypt($dto->getPassword())
        ]);

        $data = [
            "user" => $user,
            "token" => $user->createToken(TokenConstant::TOKEN_NAME)->plainTextToken
        ];
        return $this->responseBuilder(Response::HTTP_CREATED, "Qeydiyyat uğurla tamamlandı", $data);

    }
}