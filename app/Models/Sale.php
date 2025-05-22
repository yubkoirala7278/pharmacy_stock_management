<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'user_id',
        'sale_code',
        'sale_date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'customer_name',
        'customer_phone'
    ];

    protected static function booted()
    {
        static::creating(function ($sale) {
            // Use sale_code if available, fallback to timestamp
            $baseSlug = Str::slug($sale->sale_code ?? now()->timestamp);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $sale->slug = $slug;
        });
    }
}
