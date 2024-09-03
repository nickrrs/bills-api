<?php

namespace App\Http\DTO\Category;

use App\Traits\FillableFromArray;

class UpdateCategoryDTO
{
    use FillableFromArray;

    public $title;

    public $color;

    public function __construct(array $data, $existingData = [])
    {
        $this->fillFromArray($data, $existingData);
    }
}
