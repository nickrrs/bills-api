<?php

namespace App\Services;

use App\Http\DTO\Category\{CategoryDTO, UpdateCategoryDTO};
use App\Models\{Account, Category};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function index(Account $activeAccount): LengthAwarePaginator
    {
        return Category::query()->where('account_id', $activeAccount->id)->paginate(10);
    }

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
