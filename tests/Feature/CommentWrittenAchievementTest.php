<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Listeners\AchievementCommentWrittenListener;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentWrittenAchievementTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testAchievementAfterPostingAComment()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($comment));

        $this->assertSame(1, $user->achievements->count());
    }

    public function testFiveAchievementsUponPostingTwentiethComment()
    {
        $user = User::factory()->create();

        Comment::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $twentiethComment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($twentiethComment));

        $this->assertSame(5, $user->achievements->count());
    }

    public function testFireAnEventWhenAnAchievementIsAwarded()
    {
        Event::fake();

        $user = User::factory()->create();

        Comment::factory()->count(19)->create([
            'user_id' => $user->id,
        ]);

        $twentiethComment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($twentiethComment));

        $achievement = $user->achievements->last();
        
        Event::assertDispatched(function (AchievementUnlocked $event) use ($user, $achievement) {
            return $event->user->id === $user->id && $event->achievement_name == $achievement->title;
        });
    }

}
