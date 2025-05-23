<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $fillable=['sale_id','medicine_id','quantity','unit_price','subtotal'];

    // Relationship with sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relationship with medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
