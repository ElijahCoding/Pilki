<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EmployerPermissionRequest
 *
 * @property boolean $full
 * @package App\Http\Requests\Api\Crm
 */
class EmployerPermissionRequest extends FormRequest
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
            'full' => 'boolean'
        ];
    }
}
