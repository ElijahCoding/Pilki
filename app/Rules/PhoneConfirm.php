<?php

namespace App\Rules;

use App\Helpers\CacheKeys;
use Cache;
use Illuminate\Contracts\Validation\Rule;

class PhoneConfirm implements Rule
{

    protected $phone;

    /**
     * Create a new rule instance.
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Cache::get(CacheKeys::PHONE_CONFIRM_KEY . $this->phone) == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.phone_confirm');
    }
}
