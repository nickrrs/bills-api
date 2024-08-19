<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Category\{CategoryDTO, UpdateCategoryDTO};
use App\Http\Requests\Category\{StoreCategoryRequest, UpdateCategoryRequest};
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

    public function update(UpdateCategoryRequest $updateCategoryRequest, Category $category): CategoryResource | JsonResponse
    {
        try {
            $categoryDTO     = new UpdateCategoryDTO($updateCategoryRequest->validated());
            $updatedCategory = $this->categoryService->update($categoryDTO, $category);

            return new CategoryResource($updatedCategory);
        } catch (Exception $exception) {
            Log::error('Error while updating category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            $deleted = $this->categoryService->destroy($category);

            if(!$deleted) {
                return response()->json([
                    'error' => [
                        'message' => 'Error while trying deleting the category, please try again.',
                    ],
                ], 409);
            }

            return response()->json([
                'success' => [
                    'message' => 'Category deleted.',
                ],
            ]);
        } catch (Exception $exception) {
            Log::error('Error while deletinng category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
