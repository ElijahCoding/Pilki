<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EmployerScheduleStoreRequest
 *
 * @property integer $equipment_id
 * @property string $begin_at
 * @property string $end_at
 *
 * @package App\Http\Requests\Api\Crm
 */
class EmployerScheduleStoreRequest extends FormRequest
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
            'equipment_id' => 'required',
            'begin_at'     => 'required|date',
            'end_at'       => 'required|date',
        ];
    }
}
