<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Events\BadgeUnlocked;
use App\Listeners\BadgeListener;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BadgeUnlockTest extends TestCase
{
    use DatabaseTransactions;

    public function testBeginnerBadgeForLessThanFourAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $achievement = $user->achievements->first();

        (new BadgeListener())->handle(new AchievementUnlocked($user, $achievement->title));


        $this->assertSame('Beginner', $user->badges->first()->badge_name);
    }

    public function testIntermediateBadgeForFourAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(7)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new BadgeListener())->handle(new AchievementUnlocked($user, $lastAchievement->title));

        $this->assertSame('Intermediate', $user->badges->fresh()->last()->badge_name);
    }

    public function testAdvancedBadgeAchievementsGreaterThanOrEqualToEight()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(9)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $lastAchievement = $user->achievements->fresh()->last();

        (new BadgeListener())->handle(new AchievementUnlocked($user, $lastAchievement->title));

        $this->assertSame('Advanced', $user->badges->fresh()->last()->badge_name);
    }

    public function testMasterBadgeForGreaterThanTenAchievements()
    {
        Event::fake();
        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new BadgeListener())->handle(new AchievementUnlocked($user, Achievement::first()->title));

        $this->assertSame('Master', $user->badges->fresh()->last()->badge_name);
    }

    public function testFireEventWhenABadgeIsAssigned()
    {
        Event::fake();

        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new BadgeListener())->handle(new AchievementUnlocked($user, Achievement::first()->title));

        $badge = $user->badges->last();

        Event::assertDispatched(function(BadgeUnlocked $event) use ($user, $badge){
            return $event->badge_name == $badge->badge_name && $event->user->name == $user->name;
        });

    }

}
