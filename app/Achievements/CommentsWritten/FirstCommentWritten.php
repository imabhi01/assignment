<?php

namespace App\Achievements\CommentsWritten;

use App\Models\User;
use App\Models\Achievement;
use App\Achievements\Achievement as AchievementType;

class FirstCommentWritten extends AchievementType
{
    public $achievementType = 'comment_written';

    public $requiredAchievements = 0;

    public function __construct()
    {
        parent::__construct('First Comment Written');
    }

    /**
     *
     * @param User $user
     * @return bool
     */

    public function qualify(User $user)
    {
        return !!$user->comments()->count();
    }
}
