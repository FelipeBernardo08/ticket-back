<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $fillable = [
        'name'
    ];

    public function test($request): bool
    {
        $status = $request->input('data.status');
        if ($status) {
            return self::where('id', 4)
                ->update([
                    "name" => $status
                ]);
        }
    }
}
