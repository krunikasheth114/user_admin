<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'category' => 'required',
            'subcategory' => 'required',
            'password' => 'required|max:8',
            'profile' =>   'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
