<?php

namespace App\Achievements\LessonsWatched;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FirstLessonWatched extends AchievementType
{
    public $achievementType = 'lesson_watched';

    public function __construct()
    {
        parent::__construct('First Lesson Watched');
    }

    public function qualify(User $user)
    {
        return !!$user->watched->count();
    }
}
