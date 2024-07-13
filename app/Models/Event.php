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
        "local",
        "end_rua",
        "end_num",
        "end_bairro",
        "end_cidade",
        "end_estado",
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

    public function img()
    {
        return $this->hasMany(ImageTicket::class, 'id_event');
    }

    public function sell()
    {
        return $this->hasMany(Sell::class, 'id_event');
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
            ->with('img')
            ->orderBy('date', 'asc')
            ->get()
            ->toArray();
    }


    public function readEventsComplete(): array
    {
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTime();
        $dateString = $date->format('Y-m-d');
        return self::where('date', '>=', $dateString)
            ->with('show')
            ->with('show.atraction')
            ->with('ticket')
            ->with('img')
            ->get()
            ->toArray();
    }

    public function readEventsWithSells(): array
    {
        return self::with('sell')
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
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTime();
        $dateString = $date->format('Y-m-d');
        return self::where('id', $id)
            ->where('date', '>=', $dateString)
            ->with('show')
            ->with('show.atraction')
            ->with('ticket')
            ->with('img')
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
