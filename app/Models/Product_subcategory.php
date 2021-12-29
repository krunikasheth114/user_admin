<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_subcategory extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'product_sub_categories';

    protected $fillable = [
        'name',
        'category_id',
        'status',
    ];
    public function getCategory()
    {
        return $this->hasOne(Product_category::class, 'id', 'category_id');
    }
}
