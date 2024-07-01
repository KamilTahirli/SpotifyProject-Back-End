<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\GetCategoryDetailsRequest;
use App\Services\Common\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $categoryService
     */
    public function __construct(private CategoryService $categoryService)
    {
    }

    /**
     * @return mixed
     */
    public function getLimitedCategories(): mixed
    {
        try {
            $response = $this->categoryService->getLimitedCategories();
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllCategories(Request $request): mixed
    {
        try {
            $response = $this->categoryService->getAllCategories($request->input('admin'));
            return $this->successResponse($response['data'], $response['message'], Response::HTTP_OK, "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param GetCategoryDetailsRequest $request
     * @return JsonResponse
     */
    public function getCategoryDetails(GetCategoryDetailsRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->categoryService->getCategoryDetails($request->all()), "", Response::HTTP_OK, "categoryDetails");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
