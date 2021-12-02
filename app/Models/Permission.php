<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model
{   
    use HasFactory ,HasRoles;
    protected $table= 'permissions';
    protected $gaurded = [
      
    ];

    public function rolePermission()
    {
        return $this->hasMany(Document::class, 'user_id', 'id');
    }

}
