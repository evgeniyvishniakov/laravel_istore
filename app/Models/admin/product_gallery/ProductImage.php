<?php

namespace App\Models\admin\product_gallery;

use App\Models\admin\product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_url', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
