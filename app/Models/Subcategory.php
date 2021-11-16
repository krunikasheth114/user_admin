<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = [
        'subcategory_name',
        'status',
        'category_id',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
