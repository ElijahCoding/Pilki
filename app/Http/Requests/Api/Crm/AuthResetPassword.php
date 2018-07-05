<?php

namespace App\Http\Requests\Api\Crm;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthResetPassword
 *
 * @property string $email
 * @property string $remember_token
 * @property string $new_password
 *
 * @package App\Http\Requests\Api\Crm
 */
class AuthResetPassword extends FormRequest
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
            'phone' => 'required|exists:employers,phone',
        ];
    }
}
