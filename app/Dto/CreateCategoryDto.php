<?php

namespace App\Dto;

use App\Http\Requests\Admin\CreateOrUpdateCategoryRequest;

class CreateCategoryDto
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $searchQuery;

    /**
     * @var ?object
     */
    private ?object $image;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var string
     */
    private string $color;

    /**
     * @param CreateOrUpdateCategoryRequest $request
     */
    public function __construct(CreateOrUpdateCategoryRequest $request)
    {
        $this->name = $request->name;
        $this->slug = $request->slug;
        $this->searchQuery = $request->search_query;
        $this->image = $request?->image;
        $this->status = $request->status;
        $this->color = $request->color;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getSearchQuery(): string
    {
        return $this->searchQuery;
    }

    /**
     * @return ?object
     */
    public function getImage(): ?object
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }
}