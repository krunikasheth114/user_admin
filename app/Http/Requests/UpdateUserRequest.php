<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
    // {dd($this->id);
        {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
             'email' =>   'required|unique:users,email,' . $this->id,
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
