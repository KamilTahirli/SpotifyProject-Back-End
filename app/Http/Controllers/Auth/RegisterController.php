<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{

    /**
     * @param RegisterService $registerService
     */
    public function __construct(private RegisterService $registerService)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $response = $this->registerService->register($request->toDto());
            return $this->successResponse($response['data'], $response['message'], $response['status']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
