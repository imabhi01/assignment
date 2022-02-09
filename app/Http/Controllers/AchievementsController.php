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

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => '',
            'next_badge' =>'',
            'remaining_to_unlock_next_badge' => '',
        ]);
    }
}
