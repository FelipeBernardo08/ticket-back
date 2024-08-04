<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileClient extends Model
{
    use HasFactory;

    public $fillable = [
        "name",
        "fone",
        "cpf",
        "date_born",
        "id_user"
    ];
}
