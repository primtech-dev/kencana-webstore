<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'public_id',
        'order_no',
        'customer_id',
        'branch_id',
        'status',
        'currency',
        'subtotal_before_discount',
        'discount_total',
        'subtotal_after_discount',
        'shipping_cost',
        'other_charges',
        'tax_total',
        'total_amount',
        'payment_method_id',
        'payment_status',
        'tax_breakdown',
        'discount_breakdown',
        'applied_promotions',
        'notes',
        'meta',
        'placed_at',
        'cancelled_at',
        'is_refunded',
        'address_id',
        'delivery_method',
    ];

    /**
     * Atribut yang harus di-cast ke tipe bawaan.
     *
     * @var array
     */
    protected $casts = [
        // Menggunakan Timezone untuk waktu (sesuai skema timestampTz)
        'placed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_refunded' => 'boolean',
        
        // Cast JSON fields
        'tax_breakdown' => 'array',
        'discount_breakdown' => 'array',
        'applied_promotions' => 'array',
        'meta' => 'array',
    ];

    // --- Relasi ---

    /**
     * Relasi ke model Customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relasi ke model Branch.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    /**
     * Relasi ke model PaymentMethod.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * Order memiliki banyak OrderItem.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Order_Items::class, 'order_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Addresses::class, 'address_id');
    }
}
