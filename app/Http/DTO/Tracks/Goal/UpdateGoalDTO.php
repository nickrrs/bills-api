<?php

namespace App\Http\DTO\Tracks\Goal;

class UpdateGoalDTO
{
    public $title;

    public $goal_color;

    public $description;

    public $status;

    public $actual_value;

    public $goal_value;

    public $goal_conclusion_date;

    public $account_id;

    public function __construct(array $data, $existingData = [])
    {
        $this->title                = $data['title'] ?? $existingData['title'];
        $this->goal_color           = $data['goal_color'] ?? $existingData['goal_color'];
        $this->description          = $data['description'] ?? $existingData['description'] ?? "";
        $this->status               = $data['status'] ?? $existingData['status'];
        $this->actual_value         = $data['actual_value'] ?? $existingData['actual_value'];
        $this->goal_value           = $data['goal_value'] ?? $existingData['goal_value'];
        $this->goal_conclusion_date = $data['goal_conclusion_date'] ?? $existingData['goal_conclusion_date'];
    }
}
