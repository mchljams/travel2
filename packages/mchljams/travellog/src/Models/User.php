<?php

namespace Mchljams\TravelLog\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mchljams\TravelLog\Models\Traits\UserGuardTrait;
use Mchljams\TravelLog\Models\Itinerary;

class User extends Authenticatable
{
    use Notifiable;
    use UserGuardTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $with = [
        'itineraries'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Get the comments for the blog post.
     */
    public function itineraries()
    {
        return $this->hasMany(Itinerary::class)->select('id', 'user_id', 'name');
    }
}
