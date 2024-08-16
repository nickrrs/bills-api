<?php

use App\Models\{User};
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\{actingAs, post};

it('required values to register as an user', function ($field, $value) {
    post(route('v1.auth.register'), [
        'first_name' => $value,
        'last_name'  => $value,
        'email'      => $value,
        'password'   => $value,
    ])->assertInvalid($field);
})->with([
    ['field' => 'first_name', 'value' => null],
    ['field' => 'last_name', 'value' => null],
    ['field' => 'email', 'value' => null],
    ['field' => 'password', 'value' => null],
]);

it('register a new user', function () {
    $payload = [
        'first_name'            => "John",
        'last_name'             => "Doe",
        'email'                 => "jhondoenewuser@example.com",
        'password'              => "password",
        'password_confirmation' => "password",
    ];

    post(route('v1.auth.register', $payload))->assertSuccessful();

});

it('required values to sign in', function ($field, $value) {
    post(route('v1.auth.login'), [
        'email'    => $value,
        'password' => $value,
    ])->assertInvalid($field);
})->with([
    ['field' => 'email', 'value' => null],
    ['field' => 'password', 'value' => null],
]);

it('user cant sign in with wrong credentials', function () {
    $payload = [
        'email'    => 'teste@teste.com',
        'password' => 'password',
    ];

    post(route('v1.auth.login'), $payload)->assertValid($payload)->assertStatus(401);
});

it('user can sign in', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);
    $payload = [
        'email'    => $user->email,
        'password' => 'password',
    ];

    post(route('v1.auth.login'), $payload)->assertValid($payload)->assertOk();
});

it('logged user can logout', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    actingAs($user)->post(route('v1.auth.logout'))->assertOk();
});
