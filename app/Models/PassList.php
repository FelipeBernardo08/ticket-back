<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassList extends Model
{
    use HasFactory;

    public $fillable = [
        'id_client',
        'id_event'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function readList(): array
    {
        return self::with('client')
            ->with('event')
            ->get()
            ->toArray();
    }

    public function createList($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function readListIdEvent(int $id): array
    {
        return self::where('id_event', $id)
            ->with('client')
            ->with('event')
            ->get()
            ->toArray();
    }

    public function deleteList(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
