<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AuthController;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;


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
        "created_for",
        "id_card_payment"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function cardPayment()
    {
        return $this->belongsTo(card_payments::class, 'id_card_payment');
    }

    public function readSells(): array
    {
        return self::get()->toarray();
    }


    public function createSell($request): array
    {
        do {
            $request['token_input'] = Str::random(30);
            $result = self::where('token_input', $request['token_input'])->get();
        } while ($result->count() > 0);

        return self::create([
            "id_user" => $request['id_user'],
            "id_event" => $request['id_event'],
            "token_input" => $request['token_input'],
            "total_price" => $request['total_price'],
            "name_ticket" => $request['name_ticket'],
            "date_event" => $request['date_event'],
            "id_card_payment" => $request['id_card_payment']
        ])->toArray();
    }

    public function readSellId(int $id): array
    {
        return self::where('id', $id)
            ->with('user')
            ->with('event')
            ->get()
            ->toArray();
    }

    public function readSellsToken($token): array
    {
        $result = self::where('token_input', $token)
            ->where('verificated', false)
            ->with('user')
            ->with('event')
            ->get()
            ->toArray();

        return $result;
    }

    public function validVerificated(int $id): bool
    {
        return self::where('id', $id)
            ->update([
                'verificated' => true
            ]);
    }
}
