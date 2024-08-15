<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Auth\RegisterDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ExceptionHandler;

    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

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

    public function login(LoginRequest $loginRequest, AuthService $authService): JsonResponse
    {
        try {
            $loginDTO = new LoginDTO($loginRequest->validated());
            $token = $authService->signIn($loginDTO);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (Exception $exception) {
            Log::error('Error while trying to sign in: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function logout(Request $request, AuthService $authService): JsonResponse
    {
        try {
            $tokenRevoked = $authService->revokeToken($request->user()->currentAccessToken());

            if ($tokenRevoked == false || $tokenRevoked == null) {
                return response()->json([
                    'error' => [
                        'message' => 'Error while trying to handle your authenticated token, please try again!',
                    ],
                ]);
            }

            return response()->json([
                'success' => [
                    'message' => 'User signed out!',
                ],
            ]);
        } catch (Exception $exception) {
            Log::error('Error while trying to sign out: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }
}
