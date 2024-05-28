<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atraction extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name'
    ];

    public function event()
    {
        return $this->hasMany(Event::class, 'id_atraction');
    }

    public function readAtractions(): array
    {
        return self::get()->toArray();
    }

    public function createAtraction($request): object
    {
        return self::create($request->all());
    }

    public function showAtractionId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function updateAtraction($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteAtraction(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }

    public function readAtractionsWithEvent(): array
    {
        return self::with('event')
            ->get()
            ->toArray();
    }

    public function showAtractionIdWithEvent(int $id): array
    {
        return self::where('id', $id)
            ->with('event')
            ->get()
            ->toArray();
    }
}
