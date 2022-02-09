<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\User;
use App\Models\Achievement;

class TenLessonsWatched extends AchievementType
{
    public $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('10 Lessons Watched');
    }

    public function qualify(User $user)
    {
        return (bool) $user->watched()->count() >= 10;
    }
}
