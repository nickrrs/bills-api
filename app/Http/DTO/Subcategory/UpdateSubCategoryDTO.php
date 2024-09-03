<?php

namespace App\Http\DTO\Subcategory;
use App\Traits\FillableFromArray;

class UpdateSubCategoryDTO
{
    use FillableFromArray;

    public $title;

    public $color;

    public $category_id;

    public function __construct(array $data, $existingData = [])
    {
        $this->fillFromArray($data, $existingData);
    }
}
