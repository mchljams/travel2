<?php

namespace Mchljams\TravelLog\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mchljams\TravelLog\Models\Traits\UserGuardTrait;
use Spatie\Activitylog\Traits\CausesActivity;

class AdminUser extends Authenticatable
{
    use Notifiable;
    use UserGuardTrait;
    use CausesActivity;

    protected $table = 'admin_users';

    protected $guard = 'admin_web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
}
