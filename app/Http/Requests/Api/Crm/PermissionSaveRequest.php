<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PermissionSaveRequest
 *
 * @property string $access_type
 * @property integer $access_id
 * @property string $permission_type
 * @proporty integer $permission_id
 * @package App\Http\Requests\Api\Crm
 */
class PermissionSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->is_superuser;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'access_type'     => 'required',
            'access_id'       => 'required|integer',
            'permission_type' => 'required',
            'permission_id'   => 'required|integer',
        ];
    }
}
