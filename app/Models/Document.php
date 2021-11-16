<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'doc_name',
        'doc_num',
        'document',
    ];

    protected $appends = ['document_url'];

    public function getDocumentUrlAttribute()
    {
        return $this->document != '' ?  asset('images/' . $this->document) : asset('images/default/default.jpg');
    }
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
