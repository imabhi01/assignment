<?php

namespace App\Providers;

use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
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
        CommentWritten::class => [
            \App\Listeners\AchievementCommentWrittenListener::class
        ],
        LessonWatched::class => [
            \App\Listeners\AchievementLessonWatchedListener::class
        ],
        AchievementUnlocked::class => [
            \App\Listeners\BadgeListener::class
        ],
        BadgeUnlocked::class => [
            \App\Listeners\BadgeListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
