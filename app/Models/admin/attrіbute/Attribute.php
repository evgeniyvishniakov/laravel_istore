<?php

namespace App\Models\admin\attrіbute;

use App\Models\admin\product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'slug'];
    public $timestamps = false;

    public function setNameAttribute($value)
    {
        // Преобразуем имя в формат slug
        $this->attributes['slug'] = Str::slug($value);
        $this->attributes['name'] = $value;  // Сохраняем name
    }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_product', 'attribute_id', 'product_id')
            ->withPivot('attribute_value_id');
    }
}
