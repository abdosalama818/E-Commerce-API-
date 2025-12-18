<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return match ($this->route()->getName()) {

            'login' => [
                'email'    => ['required', 'email'],
                'password' => ['required', 'string', 'min:8'],
            ],

            'register' => [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed', 'min:8'],
            ],

            default => [],
        };
    
    }

  
}
