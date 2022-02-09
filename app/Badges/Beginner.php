<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;
use App\Models\Badge;

class Beginner extends BadgeType
{
    public function __construct()
    {
        parent::__construct('Beginner', 0);
    }

    public function qualify(User $user): bool
    {
        return !!$user->achievements()->count();
    }
}
