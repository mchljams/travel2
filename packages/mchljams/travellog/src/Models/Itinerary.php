<?php

namespace Mchljams\TravelLog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $name
 * @property string $user_id
 */

class Itinerary extends Model
{
    protected $table = 'itineraries';

//    protected $with = [
//        'waypoints'
//    ];

    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'user_id'
    ];

}
