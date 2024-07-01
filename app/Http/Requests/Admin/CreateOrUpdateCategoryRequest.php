<?php

namespace App\Http\Requests\Admin;

use App\Constants\StatusConstant;
use App\Dto\CreateCategoryDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrUpdateCategoryRequest extends FormRequest
{

    /**
     * @return true
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return bool
     */
    protected function isUpdate(): bool
    {
        return $this->route('category') ? true : false;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', Rule::unique('categories', 'name')->ignore($this->route('category'))],
            'slug' => ['required', 'string', Rule::unique('categories', 'slug')->ignore($this->route('category'))],
            'search_query' => 'required|string',
            'status' => ['required', Rule::in([StatusConstant::ACTIVE, StatusConstant::DEACTIVE])],
            'color' => 'required|string'
        ];

        if (!$this->isUpdate()) {
            $rules['image'] = 'required';
        }

        return $rules;
    }


    /**
     * @return CreateCategoryDto
     */
    public function toDto(): CreateCategoryDto
    {
        return new CreateCategoryDto($this);
    }

}
