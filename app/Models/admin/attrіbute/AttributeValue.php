<?php

namespace App\Models\admin\attrіbute;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    // Явно укажи таблицу, если имя не соответствует стандартам Laravel
    protected $table = 'attribute_values';

    // Поля, доступные для массового заполнения
    protected $fillable = ['id','attribute_id', 'name', 'slug'];

    public $timestamps = false;
    // Связь с атрибутами (если есть таблица attributes)
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
