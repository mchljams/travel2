<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\Itinerary;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreItineraryRequest;
use Spatie\Activitylog\Models\Activity;

class ItineraryController extends BaseController
{
    /**
     * Display a listing of itineraries.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/itineraries",
     *     operationId="index",
     *     tags={"Admin / Itineraries"},
     *     description="Get All Itineraries",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/itineraries",
     *     operationId="index",
     *     tags={"Itineraries"},
     *     description="Get All Itineraries",
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
                $itineraries = Itinerary::all();


            } else {
                // load the itinerary to be updated
                $itineraries = Itinerary::where('user_id', $this->user->id)
                    ->where('user_id', $this->user->id)
                    ->get();
            }

            $this->setResponse(200, $itineraries);

        } catch (\Exception $e) {


            $this->setResponse(400);

            $this->log('There was a problem loading the itineraries', $e->getMessage(),'error');

        }

        return $this->respond();
    }

    /**
     * Store a newly created itinerary.
     *
     * @param  \Mchljams\TravelLog\Http\Requests\StoreItineraryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Post(
     *     path="/admin/itineraries",
     *     operationId="store",
     *     tags={"Admin / Itineraries"},
     *     description="Create Itinerary",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the itinerary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Updated user_id of the itinerary",
     *                     type="integer"
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
     *     path="/itineraries",
     *     operationId="store",
     *     tags={"Itineraries"},
     *     description="Create Itinerary",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the itinerary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Updated user_id of the itinerary",
     *                     type="integer"
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
    public function store(StoreItineraryRequest $request)
    {
        $validated = $request->validated();

        if($this->isAdmin == true) {
            $itinerary = Itinerary::create($validated);
        } else {
            $itinerary = new Itinerary();
            $itinerary->name = $validated['name'];
            $itinerary->user_id = $this->user->id;
            $itinerary->save();
        }

        $this->log('Itinerary Created', '');

        activity()
            ->causedBy($this->user)
            ->performedOn($itinerary)
            ->log('itinerary created');

        return $this->setResponse(201, $itinerary)->respond();
    }

    /**
     * Display the specified itinerary.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/itineraries/{itineraryId}",
     *     operationId="show",
     *     tags={"Admin / Itineraries"},
     *     description="Get an Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         description="Itinerary id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/itineraries/{itineraryId}",
     *     operationId="show",
     *     tags={"Itineraries"},
     *     description="Get an Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         description="Itinerary id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function show($id)
    {
        $itinerary = $this->findItinerary($id);


        if($itinerary) {

            $this->setResponse(200, $itinerary);
        }

        return $this->respond();
    }

    /**
     * Update the specified itinerary.
     *
     * @param  \Mchljams\TravelLog\Http\Requests\StoreItineraryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Put(
     *     path="/admin/itineraries/{itineraryId}",
     *     operationId="update",
     *     tags={"Admin / Itineraries"},
     *     description="Update Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the itinerary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Updated user_id of the itinerary",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Put(
     *     path="/itineraries/{itineraryId}",
     *     operationId="update",
     *     tags={"Itineraries"},
     *     description="Update Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the itinerary",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Updated user_id of the itinerary",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function update(StoreItineraryRequest $request, $id)
    {
        // get the validated request values if errors,
        // returns a "422 Unprocessable Entity" Response
        // with detailed error messages
        $validated = $request->validated();

        // load the itinerary object
        $itinerary = $this->findItinerary($id);

        // try/catch for updating the itinerary
        try {
            if(!is_null($itinerary)) {
                // update the itinerary with the validated request values
                $itinerary->update($validated);
                // check if the itinerary was not changed
                if (!$itinerary->wasChanged()) {
                    // when the itinerary was not changed...
                    // when the itinerary was changed..

                    $message = 'itinerary updated, no changes required';
                    activity()
                        ->causedBy($this->user)
                        ->performedOn($itinerary)
                        ->log($message);
                    // ...and return a success http status code and message

                    $this->setResponse(200, null, $message);
                }
                // when the itinerary was changed..
                $message = 'itinerary updated';
                activity()
                    ->causedBy($this->user)
                    ->performedOn($itinerary)
                    ->log('itinerary updated');
                // ...and return a success http status code and message
                $this->setResponse(202, null, $message);
            }
        } catch (\Exception $e) {
            // when there was a problem updating the itinerary return
            // a response with a bad request message and http code
            $this->setResponse(400);

            $this->log('There was a problem updating an itinerary', '','error');
        }

        return $this->respond();
    }

    /**
     * Remove the specified itinerary.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Delete(
     *     path="/admin/itineraries/{itineraryId}",
     *     operationId="destroy",
     *     tags={"Admin / Itineraries"},
     *     description="Get an Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         description="Itinerary id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Delete(
     *     path="/itineraries/{itineraryId}",
     *     operationId="destroy",
     *     tags={"Itineraries"},
     *     description="Get an Itinerary",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         description="Itinerary id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function destroy($id)
    {
        $itinerary = $this->findItinerary($id);

        try {
            if(!is_null($itinerary)) {

                activity()
                    ->causedBy($this->user)
                    ->performedOn($itinerary)
                    ->log('itinerary deleted');

                $itinerary->delete();

                return $this->setResponse(204)->respond();
            }
        } catch (\Exception $e) {

            $this->log('There was a problem deleting an itinerary', $e->getMessage() ,'error');
            return $this->setResponse(400)->respond();
        }
    }

    /**
     * Display a listing of the itinerary logs.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/itineraries/log/{itineraryId}",
     *     operationId="logs",
     *     tags={"Admin / Itineraries"},
     *     description="Get an Itineraries Log",
     *     @OA\Parameter(
     *         name="itineraryId",
     *         description="Itinerary id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function logs($id)
    {
        $itinerary = $this->findItinerary($id);


        if($itinerary) {

            $this->setResponse(200, $itinerary->activities);
        }

        return $this->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Itinerary
     */
    private function findItinerary($id) {


        try {

            if($this->isAdmin == true) {
                // load the itinerary to be updated
                $itinerary = Itinerary::findOrFail($id);
            } else {

                // load the itinerary to be updated
                $itinerary = Itinerary::where('id', $id)
                    ->where('user_id', $this->user->id)
                    ->firstOrFail();
            }

            return $itinerary;

        } catch (\Exception $e) {

            // if the itinerary was not found, then return a not found response
            $this->setResponse(404, null, 'Itinerary Not Found');

            $this->log('There was a problem loading an itinerary', $e->getMessage(), 'error');

            return null;
        }
    }
}
