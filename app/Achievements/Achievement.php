<?php

namespace App\Achievements;

use App\Models\User;

abstract class Achievement
{
    protected $model;

    public $achievementType;

    public function __construct(string $title)
    {
        $this->model = \App\Models\Achievement::firstOrCreate([
           'title' => $title,
            'achievement_type' => $this->achievementType,
        ]);
    }

    /**
     * Checks whether the user qualifies for the achievement.
     *
     * @return mixed
     */
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
