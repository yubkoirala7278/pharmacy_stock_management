<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'sale_id',
        'user_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes'
    ];

     protected $casts = [
        'payment_date' => 'date', // Cast to Carbon instance
    ];

    // Relationship with sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Create unique slug
    protected static function booted()
    {
        static::creating(function ($payment) {
            // Generate base slug from sale_id and payment_date or use timestamp as fallback
            $baseSlug = Str::slug('payment-' . ($payment->sale_id ?? 'sale') . '-' . ($payment->payment_date ?? now()->toDateString()));
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $payment->slug = $slug;
        });
    }
}
