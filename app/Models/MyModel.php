<?php

namespace App\Models;

use Illuminate\Support\Str;

abstract class MyModel extends \Illuminate\Database\Eloquent\Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }
}
