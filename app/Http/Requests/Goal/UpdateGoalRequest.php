<?php

namespace App\Http\Requests\Goal;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\{ValidationException};

class UpdateGoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'                => ['nullable', 'string'],
            'goal_color'           => ['nullable', 'string'],
            'description'          => ['nullable', 'string'],
            'status'               => ['nullable', 'string'],
            'initial_value'        => ['nullable', 'numeric'],
            'goal_value'           => ['nullable', 'numeric'],
            'goal_conclusion_date' => ['nullable', 'date'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
