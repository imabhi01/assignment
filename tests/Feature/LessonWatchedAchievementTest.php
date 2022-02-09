<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Events\LessonWatched;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Listeners\AchievementLessonWatchedListener;

class LessonWatchedAchievementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAchievementAfterWatchingALesson()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());
    }

    public function testFiveAchievementsUponWatchingTwentyFifthLesson()
    {
        $user = User::factory()->create();

        $user->lessons()->attach(Lesson::factory()->count(24)->create(), ['watched' => true]);

        $twentyFifthLesson = Lesson::factory()->create();

        $user->lessons()->attach($twentyFifthLesson, ['watched' => true]);

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($twentyFifthLesson, $user));

        $this->assertSame(5, $user->achievements->count());
    }

    public function testToPreventsDuplicateAchievements()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        $user->lessons()->attach($lesson, ['watched' => true]);

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($lesson, $user));

        $this->assertSame(1, $user->achievements->count());
    }


    public function testFireAnEventWhenAnAchievementIsAwarded()
    {
        Event::fake();

        $user = User::factory()->create();

        $user->lessons()->attach(Lesson::factory()->count(24)->create(), ['watched' => true]);

        $twentyFifthLesson = Lesson::factory()->create();

        $user->lessons()->attach($twentyFifthLesson, ['watched' => true]);

        (new AchievementLessonWatchedListener())->handle(new LessonWatched($twentyFifthLesson, $user));

        $achievement = $user->achievements->last();

        Event::assertDispatched(function (AchievementUnlocked $event) use ($user, $achievement) {
            dd($event->achievement);
            return $event->user->id === $user->id && $event->achievement == $achievement->title;
        });
    }

}
