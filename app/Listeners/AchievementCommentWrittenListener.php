<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementCommentWrittenListener
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
            return $achievement->achievementType == 'comment_written';
        })->filter(function ($filteredAchievements) use ($event) {
            return $filteredAchievements->qualify($event->comment->user);
        })->map(function ($achievement) {
            return $achievement->primaryKey();
        });
        $event->comment->user->awardAchievement($achievementIdsToAward);
    }
}
