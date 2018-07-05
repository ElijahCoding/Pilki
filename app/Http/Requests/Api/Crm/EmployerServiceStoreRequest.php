<?php


namespace App\Http\Requests\Api\Crm;


use Illuminate\Foundation\Http\FormRequest;

class EmployerServiceStoreRequest extends FormRequest
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
            'type'    => 'required|in:category,service',
            'enabled' => 'required|boolean',
        ];
    }
}
