<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //Dynamic Password Matcher for Update Profile
        Validator::extend('match_passwords', function ($attribute, $value, $parameters, $validator) {
            $confirmationField = $parameters[0] ?? null;

            if ($confirmationField === null) {
                throw new \InvalidArgumentException('Validation rule match_passwords requires a confirmation field.');
            }

            return $value === $validator->getData()[$confirmationField];
        });

        Validator::replacer('match_passwords', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $parameters[0], $message);
        });
    }
}
