<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EqualSession implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return session($attribute) == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.equal_session');
    }
}
