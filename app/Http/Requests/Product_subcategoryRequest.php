<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class Product_subcategoryRequest extends FormRequest
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
        // dd($this->all());
        return [
            'subcategory_name' => ['required',Rule::unique('product_sub_categories', 'name')->where(function ($query) {
                return $query->where('category_id', $this->category)->where('deleted_at', NULL);
            }),
         ]];
    }
}
