<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

        if ($this->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        if ($this->hasFile('avatar')) {
            $rules['avatar'] = 'image|mimes:jpeg,png,jpg,gif|max:2048'; 
        }

        return $rules;
    }
    
}
