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
        "pix_key",
        "type_pix_key"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

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

    public function updateProductor($request, $id): bool
    {
        return self::where('id_user', $id)
            ->update([
                'name' => $request->name,
                'fone' => $request->fone,
                'account_bank' => $request->account_bank,
                'account_name' => $request->account_name,
                'pix_key' => $request->pix_key,
                'type_pix_key' => $request->type_pix_key
            ]);
    }
}
