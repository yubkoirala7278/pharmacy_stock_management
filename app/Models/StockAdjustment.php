<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory;
    protected $fillable = ['medicine_id', 'user_id', 'quantity', 'type', 'reason', 'adjustment_date'];

     protected $casts = [
        'adjustment_date' => 'date', // Cast to Carbon instance
    ];

    // Relationship with medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
