<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\{ValidationException};

class StoreCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'      => ['required', 'string'],
            'color'      => ['required', 'string'],
            'account_id' => ['required', 'string', 'exists:accounts,id'],
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
