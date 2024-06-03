<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function readImagesEvents(int $id): array
    {
        return self::where('id_event', $id)
            ->get()
            ->toArray();
    }

    public function readAllImagesEvents(): array
    {
        return self::get()->toArray();
    }

    public function deleteImgEvent(int $id): bool
    {
        $img = self::where('id', $id)->get()->toArray();
        Storage::disk('public')->delete($img[0]['img']);
        return self::where('id', $id)
            ->delete();
    }
}
