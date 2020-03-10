<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomersRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|unique:customers',
            'nok_name'=> 'required',
            'nok_phone'=>'required|max:15',
            'country_id'=>'required'
        ];
    }

    public function messages() 
    {
        return [
            'email.unique' => 'This email belongs to a customer',
            'nok_name.required'=> 'Please enter next of kin name',
            'country_id.required' => 'Please select a country',
            'nok_phone.required' => 'Next of kin contact is required'
        ];
    }
}
