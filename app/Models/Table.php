<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'descripton',
        'reserved',
        'verificated'
    ];

    public function readTables(): array
    {
        return self::get()->toArray();
    }

    public function createTable($request): bool
    {
        return self::create($request->all());
    }

    public function readTableId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function updateTable($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteTable(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
