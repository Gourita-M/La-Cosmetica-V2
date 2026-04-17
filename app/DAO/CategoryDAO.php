<?php

namespace App\DAO;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryDAO
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function create(array $payload): Category
    {
        return Category::create($payload);
    }

    public function update(Category $category, array $payload): Category
    {
        $category->update($payload);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
