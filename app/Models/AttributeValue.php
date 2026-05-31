<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $primaryKey = 'value_id';
    protected $fillable = ['attribute_id','value','display_order'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function getRouteKeyName()
{
    return 'value_id';
}

}

