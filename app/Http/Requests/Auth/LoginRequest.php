<?php

namespace App\Http\Requests\Auth;

use App\Dto\Auth\LoginDto;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email" => "required|email|string",
            "password" => "required|string"
        ];
    }

    /**
     * @return LoginDto
     */
    public function toDto(): LoginDto
    {
        return new LoginDto($this);
    }
}
