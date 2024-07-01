<?php

namespace App\Http\Requests\Front;

use App\Dto\ArtistDetailsDto;
use Illuminate\Foundation\Http\FormRequest;

class GetCategoryDetailsRequest extends FormRequest
{

    /**
     * @return true
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "category_slug" => "required|string|exists:categories,slug"
        ];
    }
}
