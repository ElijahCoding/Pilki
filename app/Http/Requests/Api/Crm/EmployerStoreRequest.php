<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

class EmployerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'work_position_id' => 'required|integer',
            'first_name'       => 'required',
            'last_name'        => 'required',
            'email'            => 'required|unique:employers|max:255',
            'phone'            => 'required|unique:employers',
            'password'         => 'required|min:4',
        ];
    }
}
