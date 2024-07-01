<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class GetSimilarMusicsRequest extends FormRequest
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
            'music_name' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'music_name.required' => 'Mahnı adı boş daxil edilə bilməz'
        ];
    }
}
