<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'blog_id',
        'url',
        'ip'

    ];
    public function blogUrl()
    {
        return $this->url;
    }
}
