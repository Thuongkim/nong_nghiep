<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\SendActiveCode' => [
        //     'App\Listeners\SendActiveCodeListener',
        // ],
        // 'App\Events\ActiveSuccessfully' => [
        //     'App\Listeners\ActiveSuccessfullyListener',
        // ],
        // 'App\Events\RegisterSuccessfully' => [
        //     'App\Listeners\RegisterSuccessfullyListener',
        // ],
        // 'App\Events\SocialRegisterSuccessfully' => [
        //     'App\Listeners\SocialRegisterSuccessfullyListener',
        // ],
        // 'App\Events\LoginSuccessfully' => [
        //     'App\Listeners\LoginSuccessfullyListener',
        // ],
        // 'App\Events\MessagePublished' => [
        //     'App\Listeners\EventListener',
        // ],
        // 'App\Events\NotificationPublished' => [
        //     'App\Listeners\NotificationEventListener',
        // ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        //'App\Listeners\LoginSuccessfullyListener',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
