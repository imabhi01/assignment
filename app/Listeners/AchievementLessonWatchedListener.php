<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementLessonWatchedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $achievementIdsToAward = app('achievements')->filter(function ($achievement) {
            return $achievement->achievementType == 'lesson_watched';
        })->filter(function ($filteredAchievements) use ($event) {
            return $filteredAchievements->qualify($event->user);
        })->map(function ($achievement) {
            return $achievement->primaryKey();
        });

        $event->user->awardAchievement($achievementIdsToAward);
    }
}
