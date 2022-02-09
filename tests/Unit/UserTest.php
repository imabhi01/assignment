<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testUserHasManyComments()
    {
        $user = User::factory()->create();

        Comment::factory()->make([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(HasMany::class, $user->comments());
    }

    public function testUserHasManyAchievements()
    {
        $user = User::factory()->create();

        Achievement::factory()->count(10)->afterMaking(function ($achievement) use ($user) {
            $achievement->user()->attach($user);
        });

        $this->assertInstanceOf(BelongsToMany::class, $user->achievements());
    }

    public function testUserCanAwardAchievement()
    {
        $this->withoutEvents();

        $user = User::factory()->create();

        Comment::factory()->count(2)->create([
            'user_id' => $user->id
        ]);

        $achievements = Achievement::factory()->count(2)->create([
            'achievement_type' => 'comment_written',
        ])->pluck('id');

        $user->awardAchievement($achievements);

        $this->assertSame(2, $user->achievements->count());
    }

    public function testUserBelongsToManyBadges()
    {
        $user = User::factory()->make();

        Badge::factory()->count(10)->afterMaking(function ($badge) use ($user) {
            $badge->user()->attach($user);
        });

        $this->assertInstanceOf(BelongsToMany::class, $user->badges());
    }

    
    public function testUserCanAchieveBadges()
    {
        $this->withoutEvents();

        $user = User::factory()->create();

        $badges = Badge::factory()->count(10)->create()->pluck('id');

        $user->assignBadges($badges);

        $this->assertSame(10, $user->badges->count());

    }

}
