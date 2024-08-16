<?php

namespace App\Http\DTO\Category;

class CategoryDTO
{
    public $title;

    public $color;

    public $account_id;

    public function __construct(array $data)
    {
        $this->title      = $data['title'];
        $this->color      = $data['color'];
        $this->account_id = $data['account_id'];
    }
}
