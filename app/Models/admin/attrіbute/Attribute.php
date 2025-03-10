<?php

namespace App\Models\admin\attrіbute;

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
}
