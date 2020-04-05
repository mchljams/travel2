<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\Itinerary;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreItineraryRequest;

class ItineraryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //dd($this->isAdmin);
        if ($this->isAdmin == true) {
            // load the itinerary to be updated
            $itineraries = Itinerary::all();


        } else {
            // load the itinerary to be updated
            $itineraries = Itinerary::where('user_id', $this->user->id)
                ->where('user_id', $this->user->id)
                ->get();
        }


        return $this->setResponse(200, $itineraries)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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

        $this->log('Itinerary Created');

        return $this->setResponse(201, $itinerary)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
                    // ...set the message
                    $message = 'Itinerary Update Received, But No Changes Made';
                    // ...log the message
                    $this->log($message);
                    // ...and return a success http status code and message
                    $this->setResponse(200, null, $message);
                }
                // when the itinerary was changed..
                // ...set the message
                $message = 'Itinerary Updated';
                // ...log the message
                $this->log($message);
                // ...and return a success http status code and message
                $this->setResponse(202, null, $message);
            }
        } catch (\Exception $e) {
            // when there was a problem updating the itinerary return
            // a response with a bad request message and http code
            $this->setResponse(400);
        }

        return $this->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $itinerary = $this->findItinerary($id);

        try {
            $itinerary->delete();
        } catch (\Exception $e) {

            $this->log('There was a problem deleting an itinerary');
            return $this->setResponse(400)->respond();
        }

        $this->log('Itinerary Deleted');
        return $this->setResponse(204)->respond();
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

            $this->log('There was a problem loading an itinerary');

            return null;
        }
    }
}
