<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class SearchMusicRequest extends FormRequest
{

    /**
     * @return bool
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
            'query' => 'required|max:250'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'query.required' => 'Axtarış sözü daxil edilmədi',
            'query.max' => 'Axtarış sözü çox uzundur',
        ];
    }
}
