<?php

namespace App\Http\Requests\Front;

use App\Dto\ArtistDetailsDto;
use Illuminate\Foundation\Http\FormRequest;

class GetArtistDetailsRequest extends FormRequest
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
            "artist_slug" => "required|string|exists:artists,slug"
        ];
    }
}
