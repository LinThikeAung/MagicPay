<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        //unique nay yar mar table name nae column name
        return [
            'name'=>"required",
            'email'=>"required|email|unique:adminusers,email",
            'phone'=>"required|unique:adminusers,phone",
            'password'=>"required|min:8|max:20"
        ];
    }
}
