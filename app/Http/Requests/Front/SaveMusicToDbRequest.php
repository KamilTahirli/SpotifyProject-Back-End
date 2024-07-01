<?php

namespace App\Http\Requests\Front;

use App\Dto\MusicDto;
use Illuminate\Foundation\Http\FormRequest;

class SaveMusicToDbRequest extends FormRequest
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
            'music_id' => 'string|required|unique:music_histories,music_id|max:100',
            'music_url' => 'string|required',
            'music_name' => 'string|required'
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
