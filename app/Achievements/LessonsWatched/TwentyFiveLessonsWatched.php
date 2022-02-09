<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;
use App\Models\Achievement;

class TwentyFiveLessonsWatched extends AchievementType
{
    public $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('25 Lessons Watched');
    }

    public function qualify(User $user)
    {
        return (bool) $user->watched()->count() >= 25;
    }
}
