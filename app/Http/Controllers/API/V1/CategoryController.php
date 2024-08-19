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
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use ExceptionHandler;

    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(Request $request): ResourceCollection | JsonResponse
    {
        try {
            $categories = $this->categoryService->index($request->user()->activeAccount());

            return CategoryResource::collection($categories);
        } catch (Exception $exception) {
            Log::error('Error while index category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function show(Category $category): CategoryResource | JsonResponse
    {
        try {
            return new CategoryResource($category);
        } catch (Exception $exception) {
            Log::error('Error while index category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function store(StoreCategoryRequest $storeCategoryRequest): CategoryResource | JsonResponse
    {
        try {
            $activeAccount = $storeCategoryRequest->user()->activeAccount();

            if(!filled($activeAccount)) {
                return response()->json([
                    'error' => [
                        'message' => 'Please select an account before creating a category.',
                    ],
                ]);
            }

            $categoryDTO = new CategoryDTO($storeCategoryRequest->validated());
            $categoryDTO->account_id = $activeAccount->id;

            $category = $this->categoryService->store($categoryDTO);

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
