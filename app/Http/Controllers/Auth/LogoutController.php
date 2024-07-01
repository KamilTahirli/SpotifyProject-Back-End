<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{

    /**
     * @param LogoutService $logoutService
     */
    public function __construct(private LogoutService $logoutService)
    {
    }

    public function logout()
    {
        try {
            $response = $this->logoutService->logout(auth()->user());
            return $this->successResponse([], $response['message'], $response['status']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
