<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';
    protected $primaryKey = 'subcategory_id';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image_url',
        'status',
        'priority',
    ];

    protected $casts = [
        'priority' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
