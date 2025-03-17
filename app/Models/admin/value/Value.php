<?php

namespace App\Models\admin\value;

use App\Models\admin\attrіbute\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Value extends Model
{
    use HasFactory;

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_value');
    }
}
