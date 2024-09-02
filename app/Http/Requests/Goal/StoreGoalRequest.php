<?php

namespace App\Http\Requests\Goal;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\{ValidationException};

class StoreGoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'                => ['required', 'string'],
            'goal_color'           => ['required', 'string'],
            'description'          => ['nullable', 'string'],
            'status'               => ['required', 'string'],
            'initial_value'        => ['required', 'numeric'],
            'goal_value'           => ['required', 'numeric'],
            'goal_conclusion_date' => ['required', 'date'],
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
