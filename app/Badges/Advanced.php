<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;
use App\Models\Badge;

class Advanced extends BadgeType
{
    public function __construct()
    {
        parent::__construct('Advanced', 8);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function qualify(User $user): bool
    {
        return $user->achievements()->count() >= 8;
    }
}
