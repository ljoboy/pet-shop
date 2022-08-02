<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * @return BelongsTo<Product, Category>
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'category_uuid', 'uuid');
    }
}
