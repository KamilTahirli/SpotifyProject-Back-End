<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class LogoutService extends Service
{
    /**
     * @param User $user
     * @return array
     */
    public function logout(User $user): array
    {
        $user->tokens()->delete();
        return $this->responseBuilder(Response::HTTP_OK, "Hesabdan uğurla çıxdınız");
    }
}