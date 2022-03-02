<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'token_id',
        'user_id',
        'cus_id',
        'card_id',
        'last4',
        'exp_month',
        'exp_year',
        'cvc',
        'brand',
        'default_method',
    ];
}
