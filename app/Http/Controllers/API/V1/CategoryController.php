<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Category\{CategoryDTO, UpdateCategoryDTO};
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use ExceptionHandler;

    public function __construct(private CategoryService $categoryService)
    {
    }

    public function store(StoreCategoryRequest $storeCategoryRequest): CategoryResource | JsonResponse
    {
        try {
            $categoryDTO = new CategoryDTO($storeCategoryRequest->validated());
            $category    = $this->categoryService->store($categoryDTO);

            return new CategoryResource($category);
        } catch (Exception $exception) {
            Log::error('Error while registering new category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function update(UpdateCategoryRequest $updateCategoryRequest, Category $category)
    {
        try {
            $categoryDTO = new UpdateCategoryDTO($updateCategoryRequest->validated());
            $category    = $this->categoryService->update($categoryDTO, $category);

            return new CategoryResource($category);
        } catch (Exception $exception) {
            Log::error('Error while updating category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
