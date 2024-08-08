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
        "description",
        "active",
        "id_user"
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
        return self::where('active', true)
            ->orderBy('date', 'asc')
            ->get()
            ->toArray();
    }

    public function readEventsDate(string $date, int $id_user): array
    {
        return self::where('id_user', $id_user)
            ->where('date', '>=', $date)
            ->where('active', true)
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
            ->where('active', true)
            ->with('show')
            ->with('show.atraction')
            ->with('ticket')
            ->with('img')
            ->get()
            ->toArray();
    }

    public function readEventsWithSells(int $id, int $id_user): array
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->with('sell')
            ->orderBy('date', 'asc')
            ->get()
            ->toArray();
    }

    public function readEventWithSells(int $id_user): array
    {
        return self::where('id_user', $id_user)
            ->with('sell')
            ->orderBy('date', 'asc')
            ->get()
            ->toArray();
    }

    public function changeActiveEvent($id, $id_user, $request): bool
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->update([
                'active' => $request->active
            ]);
    }

    public function createEvents($request, $auth): array
    {
        return self::create([
            "name" => $request->name,
            "date" => $request->date,
            "hour" => $request->hour,
            "local" => $request->local,
            "end_rua" => $request->end_rua,
            "end_num" => $request->end_num,
            "end_bairro" => $request->end_bairro,
            "end_cidade" => $request->end_cidade,
            "end_estado" => $request->end_estado,
            "description" => $request->description,
            "id_user" => $auth['id']
        ])->toArray();
    }

    public function showEventId(int $id, $id_user): array
    {
        date_default_timezone_set('America/Sao_Paulo');
        $date = new DateTime();
        $dateString = $date->format('Y-m-d');
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->where('date', '>=', $dateString)
            ->with('show')
            ->with('show.atraction')
            ->with('ticket')
            ->with('img')
            ->get()
            ->toArray();
    }

    public function showEventIdComplete(int $id): array
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

    public function updateEvent($request, int $id, int $id_user): bool
    {
        return self::where('id', $id)
            ->where('id', $id_user)
            ->update($request->all());
    }

    public function deleteEvent(int $id, int $id_user): bool
    {
        return self::where('id', $id)
            ->where('id_user', $id_user)
            ->where('active', false)
            ->delete();
    }
}
