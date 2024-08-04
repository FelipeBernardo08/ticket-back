<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileProductor extends Model
{
    use HasFactory;

    public $fillable = [
        "name",
        "fone",
        "cnpj",
        "id_user"
    ];
}
