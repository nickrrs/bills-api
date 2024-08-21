<?php

namespace App\Http\DTO\Subcategory;

class SubCategoryDTO
{
    public $title;

    public $color;

    public $category_id;

    public function __construct(array $data)
    {
        $this->title       = $data['title'];
        $this->color       = $data['color'];
        $this->category_id = "";
    }
}
