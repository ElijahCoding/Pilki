<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

class EmployerWindowStoreRequest extends FormRequest
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
            'service_category_id' => 'required|integer',
            'begin_at'            => 'required|date_format:Y-m-d H:i:s',
            'schedule'            => 'required|array',
        ];
    }
}
