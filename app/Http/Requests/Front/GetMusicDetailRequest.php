<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class GetMusicDetailRequest extends FormRequest
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
            'music_id' => 'required|max:150'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'music_id.required' => 'Mahnı id - si boş göndərilə bilməz'
        ];
    }
}
