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

    protected $casts = [
        'sale_date' => 'date', // Cast to Carbon instance
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with sale details
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // Relationship with payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Create unique slug
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
