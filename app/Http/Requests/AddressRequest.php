<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
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
            'lastname' => 'required',
            'email' => Rule::unique('users', 'email')->ignore($this->route('admin.address.edit'))->where(function ($query) {
                return $query->where('id', $this->id)->where('deleted_at', NULL);
            }),
            'category' => 'required',
            'subcategory' => 'required',
           

        ];
    }
    public function messages()
    {
        return [
            'email'=>'This email is alreay taken.',
            'required' => 'please Add At least one address .',
        ];
    }
}
