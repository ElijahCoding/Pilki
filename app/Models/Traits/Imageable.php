<?php

namespace App\Models\Traits;

use App\Models\Image;

trait Imageable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|null
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
