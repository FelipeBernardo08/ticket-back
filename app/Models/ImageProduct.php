<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class ImageProduct extends Model
{
    use HasFactory;

    public $fillable = [
        "img",
        "id_product"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function createImgProduct($request): array
    {
        $img = $request->file('img');
        $caminho = $img->store('images', 'public');
        return self::create([
            'img' => $caminho,
            'id_product' => $request->id_product
        ])
            ->get()
            ->toArray();
    }

    public function deleteImgProduct(int $id): bool
    {
        $img = self::where('id', $id)->get()->toArray();
        Storage::disk('public')->delete($img[0]['img']);
        return self::where('id', $id)
            ->delete();
    }
}
