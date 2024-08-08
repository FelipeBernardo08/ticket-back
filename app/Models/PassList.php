<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassList extends Model
{
    use HasFactory;

    public $fillable = [
        'id_user',
        'id_event',
        'name',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function readList(int $id_user): array
    {
        return self::where('id_user', $id_user)
            ->with('event')
            ->get()
            ->toArray();
    }

    public function createList($request, int $id_user): array
    {
        return self::create([
            'name' => $request->name,
            'id_event' => $request->id_event,
            'id_user' => $id_user,
        ])->toArray();
    }

    public function readListIdEvent(int $id, int $id_user): array
    {
        return self::where('id_event', $id)
            ->where('id_user', $id_user)
            ->with('event')
            ->get()
            ->toArray();
    }

    public function activeList(int $id, int $id_user, $request): bool
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->update([
                'status' => $request->status
            ]);
    }

    public function deleteList(int $id, int $id_user): bool
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->delete();
    }
}
