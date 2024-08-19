<?php

namespace App\Services;

use App\Http\DTO\Category\{CategoryDTO, UpdateCategoryDTO};
use App\Models\Category;

class CategoryService
{
    public function store(CategoryDTO $categoryDTO): Category
    {
        return Category::create((array) $categoryDTO);
    }

    public function update(UpdateCategoryDTO $updateCategoryDTO, Category $category): Category
    {
        $category->update((array) $updateCategoryDTO);

        return $category;
    }

    public function destroy(Category $category): bool
    {
        return $category->delete();
    }
}
