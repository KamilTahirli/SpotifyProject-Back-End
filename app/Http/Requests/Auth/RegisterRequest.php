<?php

namespace App\Http\Requests\Auth;

use App\Dto\Auth\RegisterDto;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "email" => "required|string|email|unique:users,email",
            "password" => "required|string|min:8",
            "full_name" => "required|string|min:3|max:30",
        ];
    }

    /**
     * @return RegisterDto
     */
    public function toDto(): RegisterDto
    {
        return new RegisterDto($this);
    }
}
