<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\{LoginDTO, RegisterDTO};
use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use App\Traits\ExceptionHandler;
use Exception;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Auth, Log};

class AuthController extends Controller
{
    use ExceptionHandler;

    public function __construct(private AuthService $authService)
    {
    }

    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function register(RegisterRequest $registerRequest): UserResource|JsonResponse
    {
        try {
            $registerDTO    = new RegisterDTO($registerRequest->validated());
            $registeredUser = $this->authService->newUser($registerDTO);

            return new UserResource($registeredUser);
        } catch (Exception $exception) {
            Log::error('Error while registering new user: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        try {

            if (!Auth::attempt($loginRequest->validated())) {
                return response()->json([
                    'error' => [
                        'message' => 'Wrong credentials.',
                    ],
                ], 401);
            }

            $loginDTO = new LoginDTO($loginRequest->validated());
            $token    = $this->authService->signIn($loginDTO);

            return response()->json([
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ], 200);
        } catch (Exception $exception) {
            Log::error('Error while trying to sign in: ', ['error' => $exception->getMessage(), 'status' => $exception->getCode()]);

            return $this->handleException($exception);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $tokenRevoked = $this->authService->revokeToken($request->user());

            if ($tokenRevoked == false) {
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
