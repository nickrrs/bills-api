<?php

namespace App\Http\DTO\Subcategory;

class UpdateSubCategoryDTO
{
    public $title;

    public $color;

    public $category_id;

    public function __construct(array $data, $existingData = [])
    {
        $this->title       = $data['title'] ?? $existingData['title'];
        $this->color       = $data['color'] ?? $existingData['color'];
        $this->category_id = $data['category_id'] ?? $existingData['category_id'];
    }
}
