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
        "id_user",
        "account_bank",
        "account_name",
        "pix_key"
    ];

    public function createProductor($produtctor, $id_user): array
    {
        return self::create([
            "name" => $produtctor->name,
            "fone" => $produtctor->fone,
            "cnpj" => $produtctor->cpf,
            "id_user" => $id_user
        ])
            ->toArray();
    }
}
