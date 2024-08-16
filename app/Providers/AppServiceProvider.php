<?php

namespace App\Providers;

use App\Models\{PersonalAccessToken, User};
use App\Observers\{UserObserver};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        User::observe(UserObserver::class);

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->environment(['production'])
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });

        Model::preventLazyLoading();

        JsonResource::withoutWrapping();
    }
}
