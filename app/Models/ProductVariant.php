<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;


class ProductVariant extends Model
{
  use SoftDeletes;

    protected $fillable = [
        'product_id','sku','variant_name','price_cents','retail_price_cents','cost_cents',
        'length','width','height','is_active','is_sellable'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_sellable' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'variant_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'variant_id');
    }
}
