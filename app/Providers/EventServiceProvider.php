<?php

namespace App\Providers;

use App\Events\ProlongedArchival;
use App\Listeners\LogPasswordReset;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogVerified;
use App\Listeners\ProlongedArchivalListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Verified::class => [
            LogVerified::class,
        ],
        PasswordReset::class => [
            LogPasswordReset::class,
        ],
        ProlongedArchival::class => [
            ProlongedArchivalListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
