<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SyncAchievementTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testExpectsAnArgumentForSyncingForSyncingAchievements()
    {
        $this->artisan('sync-achievements', ['achievement' => null])
        ->expectsOutput('Argument is required');
    }

    public function testSyncsAchievementsForExistingUsers()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Comment::factory()->count(10)->create([
           'user_id' => $user->id,
       ]);

        $user->lessons()
            ->attach(Lesson::factory()->count(10)->create(),
                ['watched' => true]);

        $this->artisan('sync-achievements', ['achievement' => 'comment_written'])
        ->expectsOutput('Users have been synced.');


        $this->artisan('sync-achievements', ['achievement' => 'lesson_watched'])
        ->expectsOutput('Users have been synced.');

        $this->assertSame(7, $user->achievements->fresh()->count());

    }
}
