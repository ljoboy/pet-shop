<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBrand
 */
final class Brand extends MyModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];
}
