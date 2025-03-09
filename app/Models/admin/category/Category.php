<?php

namespace App\Models\admin\category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'slug'];
    public $timestamps = false;

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = strtolower($value); // Преобразуем в нижний регистр
    }

}
