<?php

namespace App\Badges;

use App\Badges\Badge as BadgeType;
use App\Models\User;

class Master extends BadgeType
{
    public function __construct()
    {
        parent::__construct('Master', 10);
    }

    public function qualify(User $user): bool
    {
        return $user->achievements()->count() >= 10;
    }
}
