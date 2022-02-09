<?php

namespace App\Achievements\CommentsWritten;

use App\Achievements\Achievement as AchievementType;
use App\Models\Achievement;
use App\Models\User;

class FiveCommentsWritten extends AchievementType
{
    public $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('5 Comments Written');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user)
    {
        return (bool) $user->comments()->count() >= 5;
    }
}
