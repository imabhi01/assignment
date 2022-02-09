<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Listeners\AchievementLessonWatchedListener;
use App\Listeners\AchievementCommentWrittenListener;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AchievementTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserAchievementsByWritingCommentOrWatchingLesson()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        (new AchievementCommentWrittenListener())->handle(new CommentWritten($comment));

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(2, $user->achievements->count());
    }
}
