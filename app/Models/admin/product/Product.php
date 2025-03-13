<?php

namespace App\Models\admin\product;

use App\Models\admin\attrіbute\Attribute;
use App\Models\admin\attrіbute\AttributeValue;
use App\Models\admin\category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'sku', 'description', 'price', 'sale', 'quantity', 'slug', 'category_id', 'image_url', 'short_desc', 'visible'
    ];

    // Связь многие ко многим с атрибутами
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    // Связь с категорией
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
