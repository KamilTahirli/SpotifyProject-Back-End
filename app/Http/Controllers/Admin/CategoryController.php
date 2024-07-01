<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOrUpdateCategoryRequest;
use App\Models\Category;
use App\Services\Common\CategoryService;
use Exception;
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
     * @param CreateOrUpdateCategoryRequest $request
     * @return JsonResponse
     */
    public function create(CreateOrUpdateCategoryRequest $request): JsonResponse
    {
        try {
            $response = $this->categoryService->createCategory($request->toDto());
            return $this->successResponse([], $response['message'], $response['status'], "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @param $category_id
     * @return JsonResponse
     */
    public function ready($category_id): JsonResponse
    {
        try {
            $response = $this->categoryService->readyCategory($category_id);
            if ($response['status'] !== Response::HTTP_OK) {
                return $this->errorResponse($response['message'], [], $response['status']);
            }
            return $this->successResponse($response['data'], $response['message'], $response['status'], "category");
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Category $category
     * @param CreateOrUpdateCategoryRequest $request
     * @return JsonResponse
     */
    public function update(Category $category, CreateOrUpdateCategoryRequest $request): JsonResponse
    {
        try {
            $response = $this->categoryService->updateCategory($category, $request->toDto());
            return $this->successResponse([], $response['message'], $response['status'], "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $response = $this->categoryService->deleteCategory($category);
            return $this->successResponse([], $response['message'], $response['status'], "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Category $category, Request $request): JsonResponse
    {
        try {
            $response = $this->categoryService->changeStatus($category, $request->categoryStatus);
            return $this->successResponse([], $response['message'], $response['status'], "categories");
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->errorResponse(__('messages.response.error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
