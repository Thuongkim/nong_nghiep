<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\News;
use App\Comment;
use App\Observers\CommentObserver;
use App\Observers\NewsObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //public function boot()
    public function boot()
    {
        // News::observe(NewsObserver::class);
        // Comment::observe(CommentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
