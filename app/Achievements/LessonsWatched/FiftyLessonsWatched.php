<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FiftyLessonsWatched extends AchievementType
{
    public $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('50 Lessons Watched');
    }

    public function qualify(User $user)
    {
        return (bool) $user->watched()->count() >= 50;
    }
}
