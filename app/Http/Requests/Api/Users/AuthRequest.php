<?php


namespace App\Http\Requests\Api\Users;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthRequest
 *
 * @property string $phone Phone number for confirm
 * @property string $password User password
 * @property boolean remember_me Increase token expire time
 *
 * @package App\Http\Requests\Api
 */
class AuthRequest extends FormRequest
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
            'password' => 'required',
            'remember_me' => 'boolean'
        ];
    }

}