<?php

namespace Mchljams\TravelLog\Http\Controllers\API;

use Mchljams\TravelLog\Models\City;
use Mchljams\TravelLog\Http\Controllers\API\BaseController;
use Mchljams\TravelLog\Http\Requests\StoreItineraryRequest;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     *
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *
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
     *
     *     @OA\Header(
     *         header="api_key",
     *         description="Api key header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="state_name",
     *         description="State id",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="search",
     *         description="Search",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     */
    public function index(Request $request)
    {
       try {

            $state_name = $request->query('state_name');

            //$cities = City::where('state_id', $state_name)->get();

            //$cities = DB::table('cities')->where('state_id', $state_name)->get();

            $cities = DB::select('select * from cities where state_id = ?', [$state_name]);

            // I think this is slow because sqlite has to read from the machines disk.
            // need to test on MySQL

            $this->setResponse(200, $cities);

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
     *
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *     @OA\Response(response="404", ref="#/components/responses/404NotFound"),
     *
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
     *
     *     @OA\Response(response="200", ref="#/components/responses/200Success"),
     *     @OA\Response(response="400", ref="#/components/responses/400BadRequest"),
     *     @OA\Response(response="401", ref="#/components/responses/401NotAuthorized"),
     *     @OA\Response(response="404", ref="#/components/responses/404NotFound"),
     *
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
