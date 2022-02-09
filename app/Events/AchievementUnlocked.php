<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AchievementUnlocked
{
    use Dispatchable, SerializesModels;
    
    public $user;

    public $achievement_name;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $achievement_name)
    {
        $this->user = $user;
        $this->achievement_name = $achievement_name;
    }
}
