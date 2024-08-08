<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileEmployee extends Model
{
    use HasFactory;

    public $fillable = [
        "id_profileProductor",
        "name",
        "fone",
        "id_user"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function createEmployee($request, int $id_profileProductor, int $id_user): array
    {
        return self::create([
            'id_profileProductor' => $id_profileProductor,
            'name' => $request->name,
            'fone' => $request->fone,
            'id_user' => $id_user
        ])->toArray();
    }

    public function getUserEmployee(int $id_profileProductor): array
    {
        return self::where('id_profileProductor', $id_profileProductor)
            ->with('user')
            ->with('user.permission')
            ->get()
            ->toArray();
    }

    public function getUserEmployeeId(int $id, int $id_profileProductor): array
    {
        return self::where('id_user', $id)
            ->where('id_profileProductor', $id_profileProductor)
            ->with('user')
            ->with('user.permission')
            ->get()
            ->toArray();
    }
}
