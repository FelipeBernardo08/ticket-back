<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "name",
        "price",
        "description",
        "id_category"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function readProducts(): array //ok
    {
        return self::get()->toArray();
    }

    public function readProductsWithCategories(): array //ok
    {
        return self::with('category')
            ->get()
            ->toArray();
    }

    public function createProduct($request): array //ok
    {
        return self::create($request->all())->toArray();
    }

    public function showProductId(int $id): array //ok
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function showProductIdWithCategory(int $id): array //ok
    {
        return self::where('id', $id)
            ->with('category')
            ->get()
            ->toArray();
    }

    public function updateProduct($request, int $id): bool //ok
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteProduct(int $id): bool //ok
    {
        return self::where('id', $id)
            ->delete();
    }
}
