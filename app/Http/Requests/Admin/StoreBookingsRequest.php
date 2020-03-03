<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookingsRequest extends FormRequest
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
            'amount' => 'max:7',
            'customer_id' => 'required|max:5',
            'room_cat' => 'required',
            'time_from' => 'required|date_format:'.config('app.date_format').' H:i',
            'time_to' => 'required|date_format:'.config('app.date_format'). ' H:i',
            'discount_amount' => 'max:5'
        ];
    }
    public function messages()
    {
        return [
            'customer_id.required' => 'You need to select a customer to complete this booking',
            'discount_amount.max' => 'Such huge discount cannot be given!!',
            'room_cat.required' => 'Please select a room type',
            'time_to.required' => 'Kindly select exit date',
            'time_from.required' => 'Please select Check in date',
            'amount.max'  => 'Amount payable is too large please check again',
        ];
    }
    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    // }
}
