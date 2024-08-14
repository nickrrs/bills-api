<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\RegisterDTO;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ExceptionHandler;

    public function register(RegisterRequest $registerRequest, AuthService $authService): UserResource|JsonResponse
    {
        try {
            $registerDTO = new RegisterDTO($registerRequest->validated());
            $registeredUser = $authService->newUser($registerDTO);

            return new UserResource($registeredUser);
        } catch (Exception $exception) {
            Log::error('Error while registering new user: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
