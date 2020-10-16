<?php

namespace Mchljams\TravelLog\Http\Middleware;

use Closure;

class ApiHeaders
{
    /**
     * When this middleware is used, the request must want json.
     * So the header "Accepts: application/json" must be set on the client
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->wantsJson()) {
            return response()->json([
                'message' => 'Bad Request, Required Header Missing'
            ], 400);
        }
        return $next($request);
    }
}
