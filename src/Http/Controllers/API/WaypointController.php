<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\Waypoint;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreWaypointRequest;
use Spatie\Activitylog\Models\Activity;

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

    /**
     * Store a newly created waypoint.
     *
     * @param  \Mchljams\TravelLog\Http\Requests\StoreItineraryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Post(
     *     path="/admin/waypoints",
     *     operationId="store",
     *     tags={"Admin / Waypoints"},
     *     description="Create Waypoint",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     description="name of the waypoint",
     *                     type="string",
     *                     example="Visit to Chicago"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     description="city id",
     *                     type="integer",
     *                     default="16290",
     *                     example=16290
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     description="waypoint arrival date",
     *                     type="string",
     *                     example="2020-01-12"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     description="waypoint departure date",
     *                     type="string",
     *                     example="2020-01-13"
     *                 ),
     *                 @OA\Property(
     *                     property="itinerary_id",
     *                     description="itinerary id",
     *                     type="integer",
     *                     default="40",
     *                     example=40
     *
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="user id",
     *                     type="integer",
     *                     default="23",
     *                     example=23,
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Post(
     *     path="/waypoints",
     *     operationId="store",
     *     tags={"Waypoints"},
     *     description="Create Waypoint",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     description="name of the waypoint",
     *                     type="string",
     *                     example="Visit to Chicago"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     description="city id",
     *                     type="integer",
     *                     default="16290",
     *                     example=16290
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     description="waypoint arrival date",
     *                     type="string",
     *                     example="2020-01-12"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     description="waypoint departure date",
     *                     type="string",
     *                     example="2020-01-13"
     *                 ),
     *                 @OA\Property(
     *                     property="itinerary_id",
     *                     description="itinerary id",
     *                     type="integer",
     *                     default="40",
     *                     example=40
     *
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function store(StoreWaypointRequest $request)
    {
        $validated = $request->validated();

        if($this->isAdmin == true) {
            $waypoint = Waypoint::create($validated);
        } else {
            $waypoint = new Itinerary();
            $waypoint->name = $validated['name'];
            $waypoint->city_id = $validated['city_id'];
            $waypoint->arrival = $validated['arrival'];
            $waypoint->departure = $validated['departure'];
            $waypoint->itinerary_id = $validated['itinerary_id'];
            $waypoint->user_id = $this->user->id;
            $waypoint->save();
        }

        $this->log('Waypoint Created', '');

        activity()
            ->causedBy($this->user)
            ->performedOn($waypoint)
            ->log('waypoint created');

        return $this->setResponse(201, $waypoint)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
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
