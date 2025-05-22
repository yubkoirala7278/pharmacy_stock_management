<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Medicine extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'name', 'category_id', 'batch_number', 'expiry_date', 'cost_price', 'selling_price', 'stock_quantity'];
    protected static function booted()
    {
        static::creating(function ($medicine) {
            $baseSlug = Str::slug($medicine->name);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $medicine->slug = $slug;
        });
    }
}
