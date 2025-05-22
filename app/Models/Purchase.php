<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'supplier_id', 'user_id', 'purchase_code', 'purchase_date', 'total_amount'];
    protected static function booted()
    {
        static::creating(function ($purchase) {
            // You can customize this baseSlug if you want to use something other than purchase_code
            $baseSlug = Str::slug($purchase->purchase_code ?? now()->timestamp);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $purchase->slug = $slug;
        });
    }
}
