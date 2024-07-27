<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class card_payments extends Model
{
    use HasFactory;

    public $fillable = [
        "id_user",
        "items",
        "status",
        "date_create",
        "url_payment",
        "event"
    ];

    public function createCardPayment($card, $auth): object
    {
        return self::create([
            'id_user' => $auth->id,
            'items' => $card->items,
            'date_create' => $card->date_create,
            "event" => $card->event
        ]);
    }

    public function updateCardPayment($request, $auth, int $id): bool
    {
        return self::where('id', $id)
            ->where('id_user', $auth->id)
            ->update([
                'status' => $request->status
            ]);
    }

    public function updateLinkPayment($request, $auth, $id): bool
    {
        return self::where('id', $id)
            ->where('id_user', $auth->id)
            ->update([
                'url_payment' => $request->url_payment
            ]);
    }


    public function getCardsPayment(int $id): array
    {
        return self::where('id_user', $id)
            ->get()
            ->toArray();
    }

    public function deleteCardPayment(int $id_user, int $id): bool
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->where('status', '!=', 'approved')
            ->delete();
    }
}
