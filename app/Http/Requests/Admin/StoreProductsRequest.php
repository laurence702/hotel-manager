<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductsRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|integer|not_in:0',
            'description' => 'required',
            'stock_count' => 'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You need to select a customer to complete this booking',
            'price.required' => 'Please assign a price to this product',
            'price.integer'  => 'Price cannot be a negative number',
            'price.max'  => 'Price cannot exceed 6 digits, please check again',
            'description.required' => 'Please select a room type',
            'stock_count.required' => 'Please select Check in date',
            'stock_count.max' => 'Cant enter a value less than 0',
            'stock_count.integer' => 'Stock Count cannot be a negative number'
        ];
    }
}
