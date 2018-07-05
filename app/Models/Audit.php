<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @property array $changes
 * @package App\Models
 */
class Audit extends Model
{

    protected $fillable = [
        'event',
        'user_type',
        'user_id',
        'model_type',
        'model_id',
        'changes',
        'ip',
    ];

    protected $casts = [
        'changes' => 'json',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function model()
    {
        return $this->morphTo();
    }

}
