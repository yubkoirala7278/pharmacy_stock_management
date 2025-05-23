<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'supplier_id', 'user_id', 'purchase_code', 'purchase_date', 'total_amount'];

     protected $casts = [
        'purchase_date' => 'date', // Cast to Carbon instance
    ];

    // Insert unique slug
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

    // Relationship with supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with purchase details
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
