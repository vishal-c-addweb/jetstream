<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'empid'=>'required|numeric',
            'fname'=>'required|min:5|max:35',
            'lname'=>'required|min:5|max:35',
            'phone'=>'required|regex:/^\d{10}$/',
            'email'=>'required|email|unique:employees',
            'gender'=>'required',
            'address'=>'required',
            'salary'=>'required|numeric',
            'depid'=>'required',
        ];
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'empid.required' => 'The :attribute field can not be blank value',
            'fname.required' => 'The :attribute field can not be blank value',
            'lname.required' => 'The :attribute field can not be blank value',
            'phone.required' => 'The :attribute pattern is not match',

            'email.required' => 'The :attribute pattern is not match',
            'gender.required' => 'The :attribute field is not selected',
            'address.required' => 'The :attribute field can not be blank value',
            'salary.required' => 'The :attribute field can not be blank value',
            'depid.required' => 'The :attribute field can not be blank value',
              
        ];
    }
}