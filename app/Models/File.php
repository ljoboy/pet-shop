<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperFile
 */
final class File extends MyModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
    ];
}
