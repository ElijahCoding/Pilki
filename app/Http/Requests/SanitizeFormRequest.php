<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class SanitizeFormRequest extends FormRequest
{

    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $input = $this->all();
        foreach ($this->container->call([$this, 'sanitize']) as $attribute => $rule) {
            if (!isset($input[$attribute])) {
                continue;
            }
            $methodRule = camel_case('sanitize' . $rule);
            if (method_exists($this, $methodRule)) {
                $input[$attribute] = $this->$methodRule($input[$attribute]);
            }
        }
        $this->replace($input);

        return parent::createDefaultValidator($factory);
    }

    /**
     * @param $value
     * @return mixed
     */
    private function sanitizePhone($value)
    {
        $result = preg_replace('/[^\+0-9]/', '', $value);
        if ($result[0] == '8') {
            $result = '+7' . substr($result, 1);
        }
        return $result;
    }

}