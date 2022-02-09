<?php

namespace App\Providers;

use App\Achievements\CommentsWritten\FirstCommentWritten;
use App\Achievements\CommentsWritten\FiveCommentsWritten;
use App\Achievements\CommentsWritten\TenCommentsWritten;
use App\Achievements\CommentsWritten\ThreeCommentsWritten;
use App\Achievements\CommentsWritten\TwentyCommentsWritten;
use App\Achievements\LessonsWatched\FiftyLessonsWatched;
use App\Achievements\LessonsWatched\FirstLessonWatched;
use App\Achievements\LessonsWatched\FiveLessonsWatched;
use App\Achievements\LessonsWatched\TenLessonsWatched;
use App\Achievements\LessonsWatched\TwentyFiveLessonsWatched;
use App\Achievements\LessonsWatched\TwentyLessonsWatched;
use Illuminate\Support\ServiceProvider;

class AchievementServiceProvider extends ServiceProvider
{
    protected $achievements = [
        FirstCommentWritten::class,
        ThreeCommentsWritten::class,
        FiveCommentsWritten::class,
        TenCommentsWritten::class,
        TwentyCommentsWritten::class,
        FirstLessonWatched::class,
        FiveLessonsWatched::class,
        TenLessonsWatched::class,
        TwentyLessonsWatched::class,
        TwentyFiveLessonsWatched::class,
        FiftyLessonsWatched::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('achievements', function () {
            return collect($this->achievements)->map(function ($achievement) {
                return new $achievement();
            });
        });
    }
}
