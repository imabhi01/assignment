<?php

namespace App\Console\Commands;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\User;
use Illuminate\Console\Command;

class SyncAchievementsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-achievements {achievement}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs Achievements for existing users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->argument('achievement')) {
            $this->error('Argument is required');
            return 0;
        }

        $users = null;

        if ($this->argument('achievement') == 'lesson_watched') {
            $users = User::whereHas('watched')->get();
        }

        if ($this->argument('achievement') == 'comment_written') {
            $users = User::whereHas('comments')->get();
        }

        $users->each(function ($user) {
            if ($this->argument('achievement') == 'lesson_watched') {
                LessonWatched::dispatch($user->lessons->last(), $user);
            }

            if ($this->argument('achievement') == 'comment_written') {
                CommentWritten::dispatch($user->comments->last());
            }
        });

        $this->info('Users have been synced.');

        return 1;
    }
}
