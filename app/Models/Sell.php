<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    public $fillable = [
        'id_user',
        'id_ticket',
        'amount',
        'token_input',
        'total_price',
        'verificated',
        'created_for'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function readSells(): array
    {
        return self::get()->toarray();
    }

    public function readSellsWithUserAndTicket(): array
    {
        return self::with('user')
            ->with('ticket')
            ->get()
            ->toarray();
    }

    public function createSell($request): bool
    {
        return self::create($request->all());
    }

    public function readSellId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function readSellIdWithUserAndTicket(int $id): array
    {
        return self::where('id', $id)
            ->with('user')
            ->with('ticket')
            ->get()
            ->toArray();
    }

    public function updateSell($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }
}
