<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'price',
        'description',
        'id_category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function readProducts(): array
    {
        return self::get()->toArray();
    }

    public function readProductsWithCategories(): array
    {
        return self::get()
            ->with('category')
            ->toArray();
    }

    public function createProduct($request): bool
    {
        return self::create($request->all());
    }

    public function showProductId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function showProductIdWithCategory(int $id): array
    {
        return self::where('id', $id)
            ->with('category')
            ->get()
            ->toArray();
    }

    public function updateProduct($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteProduct(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
