<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAdm extends Model
{
    use HasFactory;

    public $fillable = [
        "name",
        "fone",
        "cnpj",
        "date_born",
        "id_user"
    ];
}
