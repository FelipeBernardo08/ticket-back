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
        "date",
        "hour",
        "description"
    ];

    public function show()
    {
        return $this->hasMany(Show::class, 'id_event');
    }

    public function readEvents(): array
    {
        return self::get()->toArray();
    }

    public function createEvents($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function showEventId(int $id): array
    {
        return self::where('id', $id)
            ->with('show')
            ->with('show.atraction')
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
