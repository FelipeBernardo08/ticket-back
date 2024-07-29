<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class card_payments extends Model
{
    use HasFactory;

    public $fillable = [
        "id_user",
        "id_event",
        "items",
        "status",
        "date_create",
        "date_event",
        "url_payment",
        "url_image",
        "total_value",
        "event"
    ];

    public function createCardPayment($card, $auth): object
    {
        return self::create([
            'id_user' => $auth->id,
            'items' => $card->items,
            'date_create' => $card->date_create,
            "event" => $card->event,
            "url_image" => $card->url_image,
            "total_value" => $card->total_value,
            "id_event" => $card->id_event,
            "date_event" => $card->date_event
        ]);
    }

    public function updateCardPayment($request, $auth, int $id): array
    {
        $response = self::where('id', $id)
            ->where('id_user', $auth->id)
            ->update([
                'status' => $request->status
            ]);

        if ($response == true) {
            return self::where('id', $id)
                ->where('id_user', $auth->id)
                ->get()
                ->toArray();
        } else {
            return [];
        }
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
