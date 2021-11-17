<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',

       
    ];
    // public function getLike()
    // {
    //     return $this->hasOneThrough(User::class, 'id', 'user_id');
    // }

}
