<?php

namespace App\Http\DTO\Category;

class UpdateCategoryDTO
{
    public $title;

    public $color;

    public function __construct(array $data, $existingData = [])
    {
        $this->title = $data['title'] ?? $existingData['title'];
        $this->color = $data['color'] ?? $existingData['color'];
    }
}
