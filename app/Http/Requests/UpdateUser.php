<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
        $id = $this->route('admin_user');//come from route resource name for editing request
        return [
            'name'=>"required",
            'email'=>"required|email|unique:users,email,".$id,//edit lote yin control dr
            'phone'=>"required|unique:users,phone,".$id,
        ];
    }
}
