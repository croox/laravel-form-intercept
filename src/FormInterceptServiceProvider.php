<?php

namespace Croox\FormIntercept;

use Croox\FormIntercept\Listeners\InterceptFormEmail;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class FormInterceptServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/form-intercept.php', 'form-intercept');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/form-intercept.php' => config_path('form-intercept.php'),
        ], 'form-intercept-config');

        Event::listen(MessageSending::class, InterceptFormEmail::class);
    }
}
