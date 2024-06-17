<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AuthController;
use DateTime;

class Sell extends Model
{
    use HasFactory;

    public $fillable = [
        "id_user",
        "id_event",
        "date_event",
        "token_input",
        "total_price",
        "name_ticket",
        "verificated",
        "created_for"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function readSells(): array
    {
        return self::get()->toarray();
    }

    public function readSellsWithUserAndTicket(): array
    {
        return self::with('event')
            ->with('user')
            ->orderBy('id_event')
            ->get()
            ->toArray();
    }

    public function createSell($request): array
    {
        return self::create([
            "id_user" => $request->id_user,
            "id_event" => $request->id_event,
            "token_input" => $request->token_input,
            "total_price" => $request->total_price,
            "name_ticket" => $request->name_ticket,
            "date_event" => $request->date_event,
            "verificated" => $request->verificated
        ])->toArray();
    }

    public function readSellId(int $id): array
    {
        return self::where('id', $id)
            ->with('event')
            ->get()
            ->toArray();
    }

    public function readSellsToken($token): array
    {
        $date = new DateTime();
        $dateFormat = $date->format('Y-m-d');
        $result = self::where('token_input', $token)
            ->where('date_event', $dateFormat)
            ->where('verificated', false)
            ->with('user')
            ->get()
            ->toArray();

        if ($result) {
            self::where('id', $result[0]['id'])
                ->update([
                    "verificated" => true
                ]);
            return $result;
        }
        return [];
    }


    public function updateSell($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }
}
