<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlockedAchievements = $user->achievements()->pluck('title');

        $nextAvailableAchievements = Achievement::all()
            ->whereNotIn('title', $unlockedAchievements)->pluck('title');

        $badge = $user->badges->last();

        $nextBadge = null;

        $remainingToUnlockNextBadge = 0;

        if ($badge) {
            $nextBadge = Badge::find(++$badge->id);
            $remainingToUnlockNextBadge = is_null($nextBadge) ? 0 : $nextBadge->achievements - $badge->achievements;
        }

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => is_null($badge) ? '' : $badge->badge_name,
            'next_badge' => is_null($nextBadge) ? '' : $nextBadge->badge_name,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }
}
