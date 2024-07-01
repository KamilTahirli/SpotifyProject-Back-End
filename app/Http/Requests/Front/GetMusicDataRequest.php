<?php

namespace App\Http\Requests\Front;

use App\Dto\MusicDto;
use Illuminate\Foundation\Http\FormRequest;

class GetMusicDataRequest extends FormRequest
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
            'music_id' => 'required|string|max:100'
        ];
    }


    /**
     * @return MusicDto
     */
    public function toDto(): MusicDto
    {
        return new MusicDto($this);
    }
}
