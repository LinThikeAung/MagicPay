<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Transfer extends FormRequest
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
            'tophone'=>'required',
            'amount'=>'required|integer',
        ];
    }

    public function messages(){
        return [
            'tophone.required' => "The phone is required.", // tophone return message ko customize dr
            'amount.required' => "Please fill the amount",
        ];
    }
}
