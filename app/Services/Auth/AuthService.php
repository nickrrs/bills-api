<?php

namespace App\Services\Auth;

use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function newUser(RegisterDTO $registerDTO): User
    {
        return User::create([
            'first_name' => $registerDTO->first_name,
            'last_name' => $registerDTO->last_name,
            'email' => $registerDTO->email,
            'password' => Hash::make($registerDTO->password),
        ]);
    }

    public function signIn(LoginDTO $loginDTO): string
    {
        $user = User::where('email', $loginDTO->email)->first();

        return $user->createToken(Hash::make($user->first_name).'-AuthToken', ['*'], now()->addWeek())->plainTextToken;
    }

    public function revokeToken(PersonalAccessToken $token): bool
    {
        return $token->delete();
    }
}
