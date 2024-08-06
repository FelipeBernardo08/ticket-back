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
        $payload = $request->getContent();
        if (!empty($payload)) {
            $data = json_decode($payload, true);
            $jsonString = json_encode($data);
            return self::where('id', 4)
                ->update([
                    "name" => $jsonString
                ]);
        }
    }
}
