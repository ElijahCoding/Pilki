<?php

namespace App\Models\Traits;

/**
 * Trait Translatable
 * using for translations in model via model json field
 *
 * @package App\Models\Traits
 */
trait Translatable
{
    protected static $translateEnabled = true;

    /**
     * @param $state
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function translate($state)
    {
        self::$translateEnabled = $state;
        return (new static)->newQuery();
    }

    protected function isJsonCastable($key)
    {
        return $this->hasCast($key, ['translate']) || parent::isJsonCastable($key);
    }

    protected function castAttribute($key, $value)
    {

        switch ($this->getCastType($key)) {
            case 'translate':
                if (self::$translateEnabled) {
                    $value = $this->fromJson($value) ?? $value;
                    if (is_array($value)){
                        if (isset($value[app()->getLocale()])){
                            return $value[app()->getLocale()];
                        } else {
                            return array_first($value);
                        }
                    } else {
                        return $value;
                    }
                } else {
                    return $this->fromJson($value);
                }
        }

        return parent::castAttribute($key, $value);
    }

}