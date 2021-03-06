<?php

namespace Tests\Unit;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAchievementBelongsToManyUsers()
    {
        $user = User::factory()->create();
        
        $achievement = Achievement::factory()->count(2)->create([
            'achievement_type' => 'comment_written',
        ]);

        $user->achievements()->attach($achievement);

        $this->assertInstanceOf(BelongsToMany::class, $achievement->first()->user());
    }
}
