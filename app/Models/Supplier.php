<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable=['slug','name','contact_person','email','phone','address'];
    protected static function booted()
    {
        static::creating(function ($supplier) {
            $baseSlug = Str::slug($supplier->name);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $supplier->slug = $slug;
        });
    }
}
