<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $primaryKey = 'attribute_id';
    protected $fillable = ['name','type','is_variant_attribute'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }
}

