<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaKeyword extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_meta_keywords', 'meta_keyword_id', 'product_id')->withTimestamps();
    }
}
