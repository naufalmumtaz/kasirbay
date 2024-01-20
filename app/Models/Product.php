<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'products';
    protected $fillable = [
        'title', 'description', 'price', 'slug', 'product_category_id'
    ];

    public function product_image() {
        return $this->hasMany(ProductImage::class);
    }

    public function product_category() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
