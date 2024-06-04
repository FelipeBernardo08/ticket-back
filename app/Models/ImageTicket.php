<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageTicket extends Model
{
    use HasFactory;

    public $fillable = [
        'img',
        'id_ticket'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function createImgTicket($request): array
    {
        $img = $request->file('img');
        $caminho = $img->store('images', 'public');
        return self::create([
            'img' => $caminho,
            'id_ticket' => $request->id_ticket
        ])
            ->get()
            ->toArray();
    }

    public function deleteImgTicket(int $id): bool
    {
        $img = self::where('id', $id)->get()->toArray();
        Storage::disk('public')->delete($img[0]['img']);
        return self::where('id', $id)
            ->delete();
    }
}
