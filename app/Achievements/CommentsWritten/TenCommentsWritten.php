<?php

namespace App\Achievements\CommentsWritten;

use App\Models\Achievement;
use App\Models\User;
use App\Achievements\Achievement as AchievementType;

class TenCommentsWritten extends AchievementType
{

    public $achievementType = 'comment_written';

    public function __construct()
    {
        parent::__construct('10 Comments Written');
    }

    public function qualify(User $user)
    {
        return $user->comments()->count() >= 10;
    }
}
