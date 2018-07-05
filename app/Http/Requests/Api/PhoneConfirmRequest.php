<?php


namespace App\Http\Requests\Api;


use App\Http\Requests\SanitizeFormRequest;

/**
 * Class PhoneConfirmRequest
 *
 * @property string $phone Phone number for confirm
 *
 * @package App\Http\Requests\Api
 */
class PhoneConfirmRequest extends SanitizeFormRequest
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
            'phone' => 'required',
        ];
    }

    public function sanitize()
    {
        return [
            'phone' => 'phone',
        ];
    }

}