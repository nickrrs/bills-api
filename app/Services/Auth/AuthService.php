<?php

namespace App\Services\Auth;

use App\Actions\Auth\NewUserAction;
use App\Http\DTO\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function newUser(RegisterDTO $registerDTO): User {
        return User::create([
            'first_name' => $registerDTO->first_name,
            'last_name' => $registerDTO->last_name,
            'email' => $registerDTO->email,
            'password' => Hash::make($registerDTO->password),
        ]);
    }
}
