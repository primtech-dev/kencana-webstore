<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carts extends Model
{
    Use SoftDeletes;
    protected $table = 'carts';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(Cart_Items::class, 'cart_id' , 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id', 'id');
    }
}
