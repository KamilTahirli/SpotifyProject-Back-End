<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ConvertAndSavePathRequest;
use App\Http\Requests\Front\GetMusicDataRequest;
use App\Http\Requests\Front\GetMusicDetailRequest;
use App\Http\Requests\Front\GetSimilarMusicsRequest;
use App\Http\Requests\Front\SaveMusicToDbRequest;
use App\Services\Front\MusicService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MusicController extends Controller
{
    /**
     * @param MusicService $musicService
     */
    public function __construct(private MusicService $musicService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function getTrendMusics(): JsonResponse
    {
        try {
            return $this->successResponse($this->musicService->getTrendMusicsForYt(), __('messages.response.success.get_trend_musics'), Response::HTTP_OK, "trends");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @param convertAndSavePathRequest $request
     * @return JsonResponse
     */
    public function getConvertedMp3Url(ConvertAndSavePathRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->musicService->getConvertedMp3Url($request->musicId), __('messages.response.success.music_download_prepared'), Response::HTTP_OK, "resultMusic");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchMusic(Request $request): JsonResponse
    {
        try {
            return $this->successResponse($this->musicService->getSearchResults($request->all()), "", Response::HTTP_OK, "searchResults");
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param GetMusicDataRequest $request
     * @return JsonResponse
     */
    public function getMusicData(GetMusicDataRequest $request): JsonResponse
    {
        try {
            $response = $this->musicService->getMusicData($request->toDto());
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "getMusicData");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param GetMusicDetailRequest $request
     * @return JsonResponse
     */
    public function getMusicDetail(GetMusicDetailRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->musicService->getMusicDetail($request->music_id), "", Response::HTTP_OK, "details");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSimilarMusics(GetSimilarMusicsRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->musicService->getSimilarMusics($request->music_name), "", Response::HTTP_OK, "similarMusics");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param SaveMusicToDbRequest $request
     * @return JsonResponse
     */
    public function saveMusicToDb(SaveMusicToDbRequest $request): JsonResponse
    {
        try {
            $response = $this->musicService->saveMusicToDb($request->toDto());
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "music");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function getMusicDownload($musicName)
    {
        $file = public_path('uploads/musics/' . $musicName);
        if (!file_exists($file)) {
            Log::error(__('messages.response.errors.file_not_found'));
            abort(404);
        }

        return response()->download($file);
    }

}
