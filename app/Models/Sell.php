<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    public $fillable = [
        'id_user',
        'id_ticket',
        'amount',
        'token_input',
        'total_price',
        'verificated'
    ];
}
