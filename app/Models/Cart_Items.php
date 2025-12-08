<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart_Items extends Model
{
    // use SoftDeletes;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id', 
        'product_id', 
        'variant_id', 
        'quantity', 
        'price_cents'
    ];

    
    // Pastikan ini ditambahkan agar subtotal bisa diakses langsung
    protected $appends = ['subtotal'];

    // ACCESSOR: Menghitung subtotal item (Harga per unit * Kuantitas)
    public function getSubtotalAttribute()
    {
        // price_cents adalah harga per unit saat item dimasukkan ke keranjang
        return $this->price_cents * $this->quantity;
    }
    
    // Relasi ke keranjang
    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id');
    }

    // Relasi ke variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
