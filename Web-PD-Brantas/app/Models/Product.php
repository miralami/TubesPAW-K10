<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'sold',
    ];

    public function reviews()

    {
    
        return $this->hasMany(Review::class);
    
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        $path = ltrim($this->image, '/');

        if (! Str::startsWith($path, 'storage/')) {
            $path = 'storage/' . $path;
        }

        return asset($path);
    }
}
