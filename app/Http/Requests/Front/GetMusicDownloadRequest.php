<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class GetMusicDownloadRequest extends FormRequest
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
            'music_url' => 'required|string'
        ];
    }

    /**
     * @return void
     */

    public function prepareForValidation(): void
    {
        $this->merge(['music_url' => $this->route('musicUrl')]);
    }
}
