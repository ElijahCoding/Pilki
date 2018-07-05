<?php


namespace App\Http\Requests\Api\Users;


use Illuminate\Foundation\Http\FormRequest;


/**
 * Class SocialAuthRequest
 * @package App\Http\Requests\Api\Users
 *
 * @property string $provider Social network provider name
 * @property string $code Social network code/token
 */
class SocialAuthRequest extends FormRequest
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
            'provider' => 'required',
            'code' => 'required'
        ];
    }

}