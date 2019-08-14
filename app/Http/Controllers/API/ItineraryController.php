<?php

namespace App\Http\Controllers\API;

use App\Itinerary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ItineraryController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user =  Auth::guard('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itinerary = Itinerary::all();

        return response()->json($itinerary, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $this->validateRequest($request);

        $itinerary = Itinerary::create($validated);

        $this->log('Itinerary Created');

        return response()->json($itinerary, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itinerary = Itinerary::find($id);

        return response()->json($itinerary, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $itinerary = Itinerary::findOrFail($id);

        $validated = $this->validateRequest($request);

        $itinerary->update($validated);

        $this->log('Itinerary Updated');

        return response()->json($itinerary, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);

        $itinerary->delete();

        $this->log('Itinerary Deleted');

        return response()->json(null, 204);
    }

    public function validateRequest(Request $request) {

        return $request->validate([
            'name' => 'required|regex:/^[a-zA-z0-9 ]+$/',
            'user_id' => 'sometimes|required|integer|exists:users,id'
        ]);
    }


    protected function log($action) {
        Log::info('', array(
            'action' => $action,
            'user' => $this->user->id
        ));
    }
}
