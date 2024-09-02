<?php

namespace App\Http\DTO\Tracks\Goal;

class GoalDTO
{
    public $title;

    public $goal_color;

    public $description;

    public $status;

    public $initial_value;

    public $goal_value;

    public $goal_conclusion_date;

    public $account_id;

    public function __construct(array $data)
    {
        $this->title                = $data['title'];
        $this->goal_color           = $data['goal_color'];
        $this->description          = $data['description'] ?? "";
        $this->status               = $data['status'];
        $this->initial_value        = $data['initial_value'];
        $this->goal_value           = $data['goal_value'];
        $this->goal_conclusion_date = $data['goal_conclusion_date'];
        $this->account_id           = "";
    }
}
