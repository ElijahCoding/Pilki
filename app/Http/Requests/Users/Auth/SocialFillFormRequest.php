<?php

namespace App\Http\Requests\Users\Auth;

use App\Http\Requests\SanitizeFormRequest;
use App\Rules\PhoneConfirm;

/**
 * Class SocialFillFormRequest
 *
 * @property string $phone
 * @property string $email
 * @package App\Http\Requests\Users\Auth
 */
class SocialFillFormRequest extends SanitizeFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->session()->has('user_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'      => 'required',
            'phone_code' => [
                'required',
                new PhoneConfirm($this->phone),
            ],
            'email'      => 'nullable|email',
        ];
    }

    public function sanitize()
    {
        return [
            'phone' => 'phone',
        ];
    }


}
