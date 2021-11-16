<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'category_name',
        'status',
        'created_at'
    ];

    protected $hidden = [
        'updated_at',
    ];

}
