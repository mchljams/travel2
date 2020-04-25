<?php

namespace Mchljams\TravelLog\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait UserGuardTrait
{
    /**
     * Determine the users API Guard
     *
     * @return string
     */
    public function getApiGuard()
    {
        if(Auth::guard('admin_api')->check()) {
            return "admin";
        }
        elseif(Auth::guard('api')->check()) {
            return "user";
        }
    }
}
