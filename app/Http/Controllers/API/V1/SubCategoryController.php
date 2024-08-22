<?php

namespace App\Http\Controllers\API\V1;

use App\Http\DTO\Subcategory\{SubCategoryDTO, UpdateSubCategoryDTO};
use App\Http\Requests\Subcategory\{StoreSubCategoryRequest, UpdateSubCategoryRequest};
use App\Http\Resources\SubCategoryResource;
use App\Models\{Category, Subcategory};
use App\Services\SubCategoryService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Log;

class SubCategoryController
{
    use ExceptionHandler;

    public function __construct(private SubCategoryService $subCategoryService)
    {
    }

    public function index(Request $request, Category $category): ResourceCollection | JsonResponse
    {
        try {
            $subCategories = $this->subCategoryService->index($category, $request->user()->activeAccount());

            return SubCategoryResource::collection($subCategories);
        } catch (Exception $exception) {
            Log::error('Error while index sub-categories: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function show(Category $category, Subcategory $subcategory): SubCategoryResource | JsonResponse
    {
        try {
            return new SubCategoryResource($subcategory->load(['category']));
        } catch (Exception $exception) {
            Log::error('Error while index sub-category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function store(StoreSubCategoryRequest $storeSubCategoryRequest, Category $category): SubCategoryResource | JsonResponse
    {
        try {
            $subCategoryDTO              = new SubCategoryDTO($storeSubCategoryRequest->validated());
            $subCategoryDTO->category_id = $category->id;

            $subCategory = $this->subCategoryService->store($subCategoryDTO);

            return new SubCategoryResource($subCategory);
        } catch (Exception $exception) {
            Log::error('Error while registering new sub-category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function update(UpdateSubCategoryRequest $updateSubCategoryRequest, Category $category, Subcategory $subcategory): SubCategoryResource | JsonResponse
    {
        try {
            $subCategoryDTO = new UpdateSubCategoryDTO(
                $updateSubCategoryRequest->validated(),
                $subcategory->toArray()
            );

            $updatedSubCategory = $this->subCategoryService->update($subCategoryDTO, $subcategory);

            return new SubCategoryResource($updatedSubCategory->load(['category']));
        } catch (Exception $exception) {
            Log::error('Error while updating sub-category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function destroy(Category $category, Subcategory $subcategory): JsonResponse
    {
        try {
            $deleted = $this->subCategoryService->destroy($subcategory);

            if(!$deleted) {
                return response()->json([
                    'error' => [
                        'message' => 'Error while trying deleting the sub-category, please try again.',
                    ],
                ], 409);
            }

            return response()->json([
                'success' => [
                    'message' => 'Sub-category deleted.',
                ],
            ]);
        } catch (Exception $exception) {
            Log::error('Error while deleting sub-category: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
