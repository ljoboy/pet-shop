<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class MyModel extends Model
{
    protected $hidden = [
        'id',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param string|int|float|bool $value
     * @param string|null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('uuid', $value)->firstOrFail();
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = static::max('id') + 1;
            $model->uuid = Str::uuid()->toString();
        });
    }
}
