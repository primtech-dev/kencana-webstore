<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'sku','name','short_description','description','attributes','weight_gram','is_active'
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')->withTimestamps()->using(\App\Models\ProductCategory::class);
    }
}
