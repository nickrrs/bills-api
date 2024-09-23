<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Goal */
class GoalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'goal_color'           => $this->goal_color,
            'description'          => $this->description,
            'status'               => $this->status,
            'actual_value'         => $this->actual_value,
            'goal_value'           => $this->goal_value,
            'goal_conclusion_date' => $this->goal_conclusion_date,
            'value_to_invest'      => $this->value_to_invest,
            'percentage'           => $this->percentage,
            'account'              => $this->whenLoaded('account', fn () => $this->account),
        ];
    }
}
