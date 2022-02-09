<?php

namespace App\Providers;

use App\Badges\Advanced;
use App\Badges\Beginner;
use App\Badges\Intermediate;
use App\Badges\Master;
use Illuminate\Support\ServiceProvider;

class BadgeServiceProvider extends ServiceProvider
{
    protected $badges = [
        Beginner::class,
        Intermediate::class,
        Advanced::class,
        Master::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('badges', function () {
            return collect($this->badges)->map(function ($badge) {
                return new $badge();
            });
        });
    }
}
