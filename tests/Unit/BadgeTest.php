<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Achievement;
use App\Listeners\BadgeListener;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use DatabaseTransactions;

    public function testBelongsToManyUsers()
    {
        Event::fake();

        $user = User::factory()->create();

        $achievement = Achievement::factory()->count(12)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        (new BadgeListener())->handle(new AchievementUnlocked($user, Achievement::first()->title));

        $badges = \App\Models\Badge::first();

        $this->assertInstanceOf(BelongsToMany::class, $badges->user());
    }
}
