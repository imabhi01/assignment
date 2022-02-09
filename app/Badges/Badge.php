<?php

namespace App\Badges;

use App\Models\User;

abstract class Badge
{
    protected $model;

    public function __construct(string $badge_name, int $achievements)
    {
        $this->model = \App\Models\Badge::firstOrCreate([
            'badge_name' => $badge_name,
            'achievements' => $achievements,
        ]);
    }

    abstract public function qualify(User $user);

    /**
     * Returns the primary key for respected model.
     *
     * @return mixed
     */
    public function primaryKey()
    {
        return $this->model->getKey();
    }
}
