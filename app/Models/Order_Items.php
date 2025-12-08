<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_Items extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'sku',
        'product_name',
        'unit_price',
        'line_quantity',
        'line_total_before_discount',
        'line_discount',
        'line_total_after_discount',
        'line_tax',
        'line_total',
        'tax_details',
        'discount_details',
    ];

    /**
     * Atribut yang harus di-cast ke tipe bawaan.
     *
     * @var array
     */
    protected $casts = [
        'unit_price' => 'integer',
        'line_quantity' => 'integer',
        'line_total_before_discount' => 'integer',
        'line_discount' => 'integer',
        'line_total_after_discount' => 'integer',
        'line_tax' => 'integer',
        'line_total' => 'integer',
        
        // Cast JSON fields
        'tax_details' => 'array',
        'discount_details' => 'array',
    ];

    // --- Relasi ---

    /**
     * Relasi ke model Order (Order Item adalah bagian dari satu Order).
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Relasi ke model Product (Snapshot).
     * Relasi ini boleh null karena skema onDelete('set null').
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relasi ke model ProductVariant (Snapshot).
     * Relasi ini boleh null karena skema onDelete('set null').
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
