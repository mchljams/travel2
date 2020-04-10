<?php

namespace Mchljams\TravelLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 *
 * @property string $name
 * @property string $user_id
 */

class Itinerary extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'itineraries';


//    protected $with = [
//        'activities'
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->enableLoggingModelsEvents = false;
    }
}
