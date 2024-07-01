<?php

namespace App\Services\Common;

use App\Constants\ParamsConstant;
use App\Constants\StatusConstant;
use App\Dto\CreateCategoryDto;
use App\Models\Category;
use App\Services\Front\MusicService;
use App\Services\Service;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpFoundation\Response;

class CategoryService extends Service
{

    /**
     * @return array
     */
    public function getLimitedCategories(): array
    {
        $categories = Category::query()->where('status', 'A')
            ->limit(ParamsConstant::MAX_RESULTS['LIMITED_CATEGORIES_LIST'])
            ->get();

        return [
            "success" => true,
            "message" => "kateqoriyalar",
            "data" => empty($categories) ? [] : $categories
        ];
    }


    /**
     * @param $admin
     * @return array
     */
    public function getAllCategories($admin = null): array
    {
        $query = Category::query();

        if (is_null($admin)) {
            $query->where('status', StatusConstant::ACTIVE);
        }

        $categories = $query->paginate(ParamsConstant::MAX_RESULTS['ALL_CATEGORIES_LIST']);

        return [
            "success" => true,
            "message" => "bütün kateqoriyalar",
            "data" => $categories->isEmpty() ? [] : $categories
        ];
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function getCategoryDetails(array $data): mixed
    {
        $cacheKey = 'category_details_' . md5($data['category_slug'] . (isset($data['token']) ? '_' . $data['token'] : ''));
        return Cache::remember($cacheKey, config('app.cache_seconds'), function () use ($data) {
            $category = Category::query()->where("slug", $data['category_slug'])->first();
            $data['query'] = $category['search_query'];
            return [
                "category" => $category,
                "musics" => (new MusicService())->getSearchResults($data)
            ];
        });
    }


    /**
     * @param int $categoryId
     * @return array
     */
    public function readyCategory(int $categoryId): array
    {
        $category = Category::query()->where('id', $categoryId)->first();
        if (!$category) {
            return $this->responseBuilder(Response::HTTP_NOT_FOUND, 'Kateqoriya tapılmadı');
        }
        return $this->responseBuilder(Response::HTTP_OK, 'Kateqoriya haqqında', $category->toArray());
    }

    /**
     * @param CreateCategoryDto $dto
     * @return array
     */
    public function createCategory(CreateCategoryDto $dto): array
    {
        Category::query()->create([
            'name' => $dto->getName(),
            'slug' => $dto->getSlug(),
            'search_query' => $dto->getSearchQuery(),
            'image' => $this->uploadImage($dto->getImage()),
            'status' => $dto->getStatus(),
            'color' => $dto->getColor()
        ]);

        return $this->responseBuilder(Response::HTTP_CREATED, 'Kateqoriya uğurla əlavə edildi');
    }


    /**
     * @param Category $category
     * @param CreateCategoryDto $dto
     * @return array
     */
    public function updateCategory(Category $category, CreateCategoryDto $dto): array
    {
        $imageName = !is_null($dto->getImage()) ? $this->uploadImage($dto->getImage()) : $category->image;
        $category->update([
            'name' => $dto->getName(),
            'slug' => $dto->getSlug(),
            'search_query' => $dto->getSearchQuery(),
            'image' => $imageName,
            'status' => $dto->getStatus(),
            'color' => $dto->getColor()
        ]);

        return $this->responseBuilder(Response::HTTP_OK, 'Kateqoriyaya uğurla düzəliş edildi');
    }


    /**
     * @param Category $category
     * @return array
     */
    public function deleteCategory(Category $category): array
    {
        $category->delete();
        return $this->responseBuilder(Response::HTTP_OK, 'Kateqoriyaya uğurla silindi');
    }

    /**
     * @param Category $category
     * @param string $status
     * @return array
     */
    public function changeStatus(Category $category, string $status): array
    {
        $category->status = $status;
        $category->save();
        $message = $category->status === "A" ? "Kateqoriya aktiv edildi" : "Kateqoriya deaktiv edildi";
        return $this->responseBuilder(Response::HTTP_OK, $message);
    }

    /**
     * @param object $image
     * @return string
     */
    private function uploadImage(object $image): string
    {
        $imageName = md5(Hash::make(Str::random(15) . time())) . '.' . $image->extension();
        $path = 'uploads/categories';
        $image->move(public_path($path), $imageName);
        return url($path, $imageName);
    }

}
