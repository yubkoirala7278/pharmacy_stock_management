<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'description'];

    // Relationship with medicines
    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'category_id');
    }

    // Generate unique slug
    protected static function booted()
    {
        static::creating(function ($category) {
            $baseSlug = Str::slug($category->name);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $category->slug = $slug;
        });
    }
}
