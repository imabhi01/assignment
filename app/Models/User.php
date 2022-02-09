<?php

namespace App\Models;

use App\Models\Badge;
use App\Models\Comment;
use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function awardAchievement($achievements)
    {
        $this->achievements()->syncWithoutDetaching($achievements);
        $lastAchievement = $this->achievements->last();
        AchievementUnlocked::dispatch($this, $lastAchievement->title);
        return $this;
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function assignBadges($badges)
    {
        $this->badges()->syncWithoutDetaching($badges);

        $lastBadge = $this->badges->last();

        BadgeUnlocked::dispatch($this, $lastBadge->badge_name);

        return $this;
    }
}
