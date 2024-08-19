<?php

namespace App\Observers;

use App\Models\{Account, User};

class UserObserver
{
    public function created(User $user): void
    {
        // Creates default account for the new user
        Account::create([
            'user_id' => $user->getKey(),
            'title'   => 'My account',
            'balance' => 0,
            'active'  => true,
        ]);
    }
}
