<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = ['purchase_id', 'medicine_id', 'quantity', 'unit_price', 'subtotal'];

    // Relationship with purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Relationship with medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
