<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'position', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // parent relationship (nullable)
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // children
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position');
    }

    // boot: auto-generate slug if empty
    protected static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug) && !empty($category->name)) {
                $base = Str::slug($category->name);
                $slug = $base;
                $i = 1;
                // ensure unique
                while (self::where('slug', $slug)->where('id', '<>', $category->id ?? 0)->withTrashed()->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $category->slug = $slug;
            }
        });
    }
}

