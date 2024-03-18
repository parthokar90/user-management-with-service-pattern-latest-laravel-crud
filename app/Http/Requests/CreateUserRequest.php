<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ];

        // Check if either password or avatar is present in the request
        if ($this->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        if ($this->hasFile('avatar')) {
            $rules['avatar'] = 'image|max:2048'; 
        }

        return $rules;
    }
}
