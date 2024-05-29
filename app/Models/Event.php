<?php

namespace App\Models;

use App\Http\Controllers\AtractionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "name",
        "id_atraction",
        "date",
        "hour",
        "description"
    ];

    public function atraction()
    {
        return $this->belongsTo(Atraction::class, 'id_atraction');
    }

    public function readEvents(): array
    {
        return self::get()->toArray();
    }

    public function readEventsWithAtraction(): array
    {
        return self::with('atraction')
            ->get()
            ->toArray();
    }

    public function createEvents($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function showEventId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function showEventIdWithAtractions(int $id): array
    {
        return self::where('id', $id)
            ->with('atraction')
            ->get()
            ->toArray();
    }

    public function updateEvent($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteEvent(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
