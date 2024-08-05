<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

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

    public function createClient($name, $id_user): array
    {
        return self::create([
            'name' => $name,
            'id_user' => $id_user
        ])
            ->get()
            ->toArray();
    }

    public function updateSelfClient($id, $client): bool
    {
        return self::where('id', $client->id)
            ->where('id_user', $id)
            ->update([
                "name" => $client->name,
                "fone" => $client->fone,
                "date_born" => $client->date_born,
                "cpf" => $client->cpf
            ]);
    }
}
