<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    protected $guard = 'web';

    protected $table = 'users';
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'category',
        'subcategory',
        'profile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function getSubCategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }
    public function getFullNameAttribute()
    {
        return ucfirst($this->firstname) . '  ' . ucfirst($this->lastname);
    }

    public function getProfileUrlAttribute()
    {
        return $this->profile != '' ?  asset('images/'.$this->profile) : asset('images/default/default.jpg');
    }

    public function userAddress()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function userDocument()
    {
        return $this->hasMany(Document::class, 'user_id', 'id');
    }
    public function getUser()
    {
        return $this->hasOne(Blog::class, 'user_id', 'id');
    }
 

 }
