<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentPostRequest extends FormRequest
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
            'sname'=>'required',
            'sage'=>'required|numeric',
            'saddress'=>'required|min:20',
            'spercentage'=>'required|numeric',
            'sschool'=>'required',
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
            'sname.required' => 'The :attribute field can not be blank value',
            'sage.required' => 'The :attribute field can not be blank value',
            'saddress.required' => 'The :attribute field can not be blank value',
            'spercentage.required' => 'The :attribute field is not match',
            'sschool.required' => 'The :attribute field is not match',
              
        ];
    }
}
