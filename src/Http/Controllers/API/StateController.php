<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\City;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreItineraryRequest;
use Spatie\Activitylog\Models\Activity;

class StateController extends BaseController
{
    /**
     * Display a listing of states.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/places/states",
     *     operationId="index",
     *     tags={"Admin / Places"},
     *     description="Get All States",
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/places/states",
     *     operationId="index",
     *     tags={"Places"},
     *     description="Get All States",
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function index()
    {
        try {

            $states = City::states();

            $this->setResponse(200, $states);

        } catch (\Exception $e) {


            $this->setResponse(400);

            $this->log('There was a problem loading the states', $e->getMessage(),'error');

        }

        return $this->respond();
    }
}
