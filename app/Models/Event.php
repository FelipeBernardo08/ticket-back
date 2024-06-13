<?php

namespace App\Models;

use App\Http\Controllers\AtractionController;
use DateTime;
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
        "status",
        "description"
    ];

    public function show()
    {
        return $this->hasMany(Show::class, 'id_event');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'id_event');
    }

    public function imageBanner()
    {
        return $this->hasMany(ImageTicket::class, 'id_event');
    }

    public function readEvents(): array
    {
        return self::orderBy('date', 'asc')
            ->get()
            ->toArray();
    }

    public function readEventsDate(string $date): array
    {
        return self::where('date', '>=', $date)
            ->with('imageBanner')
            ->orderBy('date', 'asc')
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
            ->with('show')
            ->with('show.atraction')
            ->with('ticket')
            ->with('imageBanner')
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
