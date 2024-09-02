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
            'id'            => $this->id,
            'title'         => $this->title,
            'color'         => $this->goal_color,
            'description'   => $this->description,
            'status'        => $this->status,
            'initial_value' => $this->initial_value,
            'goal_value'    => $this->goal_value,
            'account'       => $this->whenLoaded('account', fn () => $this->account),
        ];
    }
}
