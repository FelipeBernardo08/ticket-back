<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'id_event',
        'price'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function img()
    {
        return $this->hasMany(ImageTicket::class, 'id_ticket');
    }

    public function readTikects(): array
    {
        return self::with('img')->get()->toArray();
    }

    public function readTikectsWithEvent(): array
    {
        return self::with('event')
            ->with('event.show')
            ->with('event.show.atraction')
            ->with('img')
            ->get()
            ->toArray();
    }

    public function createTicket($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function readTicketId(int $id): array
    {
        return self::where('id', $id)
            ->with('event')
            ->with('event.show')
            ->with('event.show.atraction')
            ->with('img')
            ->get()
            ->toArray();
    }

    public function updateTicket($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteTicket(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
