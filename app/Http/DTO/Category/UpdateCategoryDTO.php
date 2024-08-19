<?php

namespace App\Http\DTO\Category;

class UpdateCategoryDTO
{
    public $title;

    public $color;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->color = $data['color'];
    }
}
