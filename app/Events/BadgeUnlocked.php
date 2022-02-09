<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    public $user, $badge_name;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $badge_name)
    {
        $this->user = $user;
        $this->badge_name = $badge_name;
    }
}
