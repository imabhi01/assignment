<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewAchievementsTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testUserCanViewTheirAchievements()
    {
        $user = User::factory()->create();

        $this->get("/users/{$user->id}/achievements")
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->whereAllType([
                'unlocked_achievements' => 'array',
                'next_available_achievements' => 'array',
                'current_badge' => 'string',
                'next_badge' => 'string',
                'remaining_to_unlock_next_badge' => 'integer',
            ]);
        });
    }

    public function testChecksForNonExistentBadges()
    {
        Event::fake();

        $user = User::factory()->create();

        $badges = Badge::factory()->count(3)->create()->pluck('id');

        $user->assignBadges([1,2,4]);

        $this->get("/users/{$user->id}/achievements")->assertStatus(200);
    }
}
