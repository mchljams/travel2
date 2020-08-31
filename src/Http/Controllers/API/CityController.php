<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\City;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreItineraryRequest;
use Spatie\Activitylog\Models\Activity;

class CityController extends BaseController
{
    /**
     * Display a listing of cities.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/places/cities",
     *     operationId="index",
     *     tags={"Admin / Places"},
     *     description="Get All Cities",
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Not Authorized", {}),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/places/cities",
     *     operationId="index",
     *     tags={"Places"},
     *     description="Get All Cities",
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

            $states = City::states();

            $this->setResponse(200, $states);

        } catch (\Exception $e) {


            $this->setResponse(400);

            $this->log('There was a problem loading the states', $e->getMessage(),'error');

        }

        return $this->respond();
    }


    /**
     * Display the specified city.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/admin/places/cities/{cityId}",
     *     operationId="show",
     *     tags={"Admin / Places"},
     *     description="Get a city",
     *
     *     @OA\Parameter(
     *         name="cityId",
     *         description="City id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @OA\Get(
     *     path="/places/cities/{cityId}",
     *     operationId="show",
     *     tags={"Places"},
     *     description="Get a city",
     *
     *     @OA\Parameter(
     *         name="cityId",
     *         description="City id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Not Authorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function show($id)
    {


        //try {

            $city = City::findOrFail($id);

            $this->setResponse(200, $city);


//        } catch (\Exception $e) {
//
//            dump($e);
//            // if the itinerary was not found, then return a not found response
//            $this->setResponse(404, null, 'City Not Found');
//
//            //die('test');
//
//            $this->log('There was a problem loading a city', $e->getMessage(), 'error');
//
//            return null;
//        }

        return $this->respond();
    }
}
