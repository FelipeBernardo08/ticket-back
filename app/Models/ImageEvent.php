<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageEvent extends Model
{
    use HasFactory;

    public $fillable = [
        "img",
        "id_event"
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function createImgEvent($request): array
    {
        $img = $request->file('img');
        $caminho = $img->store('images', 'public');
        return self::create([
            'img' => $caminho,
            'id_event' => $request->id_event
        ])
            ->get()
            ->toArray();
    }

    public function readImagesEvents(int $id_event): array
    {
        return self::where('id_event', $id_event)
            ->get()
            ->toArray();
    }

    public function deleteImageEvent(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
