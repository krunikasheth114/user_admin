<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product_categoryRequest extends FormRequest
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
            'category_name' => 'required|unique:product_categories,name,NULL,id,deleted_at,NULL',
        ];
    }
}
