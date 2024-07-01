<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    /**
     * @param LoginService $loginService
     */
    public function __construct(private LoginService $loginService)
    {
    }


    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $response = $this->loginService->login($request->toDto());
            if ($response['status'] !== Response::HTTP_OK) {
                return $this->errorResponse($response['message'], [], $response['status']);
            }
            return $this->successResponse($response['data'], $response['message'], $response['status']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
