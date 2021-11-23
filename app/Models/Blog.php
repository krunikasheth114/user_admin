<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'slug',
        'category_id',
        'user_id',
        'title',
        'description',
        'image',

    ];
    public function category()
    {
        return $this->hasOne(Blog_category::class, 'id', 'category_id');
    }
    public function blogLikes()
    {
        return $this->hasMany(Like::class, 'blog_id', 'id')->count();
    }
    public function blogComment()
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id')->count();
    }
    public function views()
    {
        return $this->hasMany(View::class, 'blog_id', 'id')->count();
    }
    public function blogUrl()
    {
        return $this->hasOne(View::class, 'blog_id', 'id');
    }
   
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getImageUrlAttribute()
    {
        return $this->image != '' ?  asset('images/' . $this->image) : asset('images/default/default.jpg');
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function bloglike()
    {
        return $this->hasMany(Like::class, 'blog_id', 'id');
    }
    public function blogcomments()
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id');
    }
    
    public function blogviews()
    {
        return $this->hasMany(View::class, 'blog_id', 'id');
    }

 
   
}
