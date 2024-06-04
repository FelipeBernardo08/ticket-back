<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'id_atraction',
        'id_event',
        'date',
        'hour'
    ];

    public function atraction()
    {
        return $this->belongsTo(Atraction::class, 'id_atraction');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function readShows(): array
    {
        return self::with('event')
            ->with('atraction')
            ->get()
            ->toArray();
    }

    public function readShowId(int $id): array
    {
        return self::where('id', $id)
            ->with('atraction')
            ->with('event')
            ->get()
            ->toArray();
    }

    public function createShow($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function updateShow($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteShow(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
