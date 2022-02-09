<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $badgeIdsToAssign = app('badges')
            ->filter(function ($filteredBadges) use ($event) {
                return $filteredBadges->qualify($event->user);
            })->map(function ($badge) {
                return $badge->primaryKey();
            });

        $event->user->assignBadges($badgeIdsToAssign);
    }
}
