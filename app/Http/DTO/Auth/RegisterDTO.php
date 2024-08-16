<?php

namespace App\Http\DTO\Auth;

class RegisterDTO
{
    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public function __construct(array $data)
    {
        $this->first_name = $data['first_name'];
        $this->last_name  = $data['last_name'];
        $this->email      = $data['email'];
        $this->password   = $data['password'];
    }
}
