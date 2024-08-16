<?php

namespace App\Http\DTO\Auth;

class LoginDTO
{
    public $email;

    public $password;

    public function __construct(array $data)
    {
        $this->email    = $data['email'];
        $this->password = $data['password'];
    }
}
