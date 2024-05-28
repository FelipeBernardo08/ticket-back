<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function readCategories(): array
    {
        return self::get()->toArray();
    }

    public function readCategoriesWithProducts(): array
    {
        return self::get()->with('products')->toArray();
    }

    public function createCategory($request): array
    {
        return self::create($request->all())->toArray();
    }

    public function showCategoryId(int $id): array
    {
        return self::where('id', $id)
            ->get()
            ->toArray();
    }

    public function showCategoryIdWithProducts(int $id): array
    {
        return self::where('id', $id)
            ->with('products')
            ->get()
            ->toArray();
    }

    public function updateCategory($request, int $id): bool
    {
        return self::where('id', $id)
            ->update($request->all());
    }

    public function deleteCategory(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }
}
