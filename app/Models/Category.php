<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperCategory
 */
final class Category extends MyModel
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title'
    ];
}
