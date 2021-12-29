<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product_category;
use App\Models\Product_subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    
    protected $fillable = [
        'id',
        'category_id',
        'subcategory_id',
        'name',
        'price',
        'status',
        'image',
        
    ];
    public function getCategory()
    {
        return $this->hasOne(Product_category::class, 'id', 'category_id');
    }

    public function subCategory()
    {
        return $this->hasOne(Product_subcategory::class, 'id', 'subcategory_id');
    }
    public function getImageUrlAttribute()
    {
        return $this->image != '' ?  asset('/images/' . $this->image) : asset('images/default/default.jpg');
    }
   
}
