<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;
use App\Models\Achievement;

class TwentyLessonsWatched extends AchievementType
{
    public $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('20 Lessons Watched');
    }

    public function qualify(User $user)
    {
        return (bool) $user->watched()->count() >= 20;
    }
}
