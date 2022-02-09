<?php

namespace App\Achievements\CommentsWritten;

use App\Models\User;
use App\Models\Achievement;
use App\Achievements\Achievement as AchievementType;

class FirstCommentWritten extends AchievementType
{
    public $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('First Comment Written');
    }

    public function qualify(User $user)
    {
        return $user->comments()->count() >= 1;
    }
}
