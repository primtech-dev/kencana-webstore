<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $guarded = ['id'];

    // variant nya ada ga di inventory
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // cabang nya ada ga di inventory
    public function cabang()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
