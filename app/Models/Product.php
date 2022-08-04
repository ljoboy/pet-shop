<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


/**
 * @mixin IdeHelperProduct
 */
final class Product extends MyModel
{
    use HasFactory, HasJsonRelationships;

    protected $fillable = [
        'title',
        'description',
        'metadata',
        'price',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    protected $hidden = [
        'id',
    ];

    /**
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    /**
     * @return BelongsTo<Brand, Product>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class,  'metadata->brand', 'uuid');
    }
}
