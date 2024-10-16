<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atraction extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'id_user'
    ];

    public function show()
    {
        return $this->hasMany(Show::class, 'id_atraction');
    }

    public function readAtractions(): array
    {
        return self::get()->toArray();
    }

    public function createAtraction($request, $id_user): object
    {
        return self::create([
            'name' => $request->name,
            'id_user' => $id_user
        ]);
    }

    public function readAtrctionWithEventAndSell($id): array
    {
        return self::where('id_user', $id)
            ->with('show')
            ->get()
            ->toArray();
    }

    public function showAtractionId(int $id): array
    {
        return self::where('id', $id)
            ->with('show')
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

    public function readAtractionsWithShow(): array
    {
        return self::with('show')
            ->get()
            ->toArray();
    }
}
