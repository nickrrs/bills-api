<?php

namespace App\Services;

use App\Http\DTO\Subcategory\{SubCategoryDTO, UpdateSubCategoryDTO};
use App\Models\{Account, Category, Subcategory};

class SubCategoryService
{
    public function index(Category $category, Account $account)
    {
        return Subcategory::query()
            ->with(['category'])
            ->whereHas('category', function ($query) use ($account) {
                $query->where('account_id', $account->id);
            })
            ->paginate(10);
    }

    public function store(SubCategoryDTO $subCategoryDTO): Subcategory
    {
        return Subcategory::create((array) $subCategoryDTO);
    }

    public function update(UpdateSubCategoryDTO $updateSubCategoryDTO, Subcategory $subcategory): Subcategory
    {
        $subcategory->update((array) $updateSubCategoryDTO);

        return $subcategory;
    }

    public function destroy(Subcategory $subcategory): bool
    {
        return $subcategory->delete();
    }
}
