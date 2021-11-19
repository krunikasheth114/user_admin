<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',
        'comment'

       
    ];
    public function getBlog()
    {
        return $this->hasOne(Blog::class, 'id', 'blog_id');
    }
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
