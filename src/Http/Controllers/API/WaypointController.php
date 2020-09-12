<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\Waypoint;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;

class WaypointController extends BaseController
{
    /**
     * Display a listing of waypoints.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/waypoints",
     *     operationId="index",
     *     tags={"Admin / Waypoints"},
     *     description="Get All Waypoints",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized", {}),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/waypoints",
     *     operationId="index",
     *     tags={"Waypoints"},
     *     description="Get All Waypoints",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function index()
    {
        try {
            if ($this->isAdmin == true) {
                // load the itinerary to be updated
                $waypoints = Waypoint::all();


            } else {
                // load the itinerary to be updated
                $waypoints = Waypoint::where('user_id', $this->user->id)
                    ->where('user_id', $this->user->id)
                    ->get();
            }

            $this->setResponse(200, $waypoints);

        } catch (\Exception $e) {


            $this->setResponse(400);

            $this->log('There was a problem loading the waypoints', $e->getMessage(),'error');

        }

        return $this->respond();
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}
