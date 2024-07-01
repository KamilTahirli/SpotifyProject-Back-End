<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\GetArtistDetailsRequest;
use App\Services\Front\ArtistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends Controller
{
    /**
     * @param ArtistService $artistService
     */
    public function __construct(private ArtistService $artistService)
    {
    }

    /**
     * @return mixed
     */
    public function getLimitedArtists(): mixed
    {
        try {
            $response = $this->artistService->getLimitedArtists();
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "artists");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @return mixed
     */
    public function getAllArtists(): mixed
    {
        try {
            $response = $this->artistService->getAllArtists();
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "artists");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @param GetArtistDetailsRequest $request
     * @return JsonResponse
     */
    public function getArtistDetails(GetArtistDetailsRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->artistService->getArtistDetails($request->all()), "", Response::HTTP_OK, "artistDetails");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
