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

    public function createClient($client): array
    {
        return self::create($client->all());
    }

    public function updateSelfClient($id, $client): bool
    {
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTime($client->date_bnorn);
        return self::where('id', $client->id)
            ->where('id_user', $id)
            ->update([
                "name" => $client->name,
                "fone" => $client->fone,
                "date_born" => $date
            ]);
    }
}
