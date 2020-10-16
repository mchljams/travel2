<?php


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Travel Log Documentation",
 *      description="Travel Logs OpenAPI Specification",
 *      @OA\Contact(
 *          email="michael.james@mchljams.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 *
 * @OA\Tag(
 *     name="Admin / Itineraries",
 *     description="Admin API Endpoints of Itineraries"
 * )
 *
 * @OA\Tag(
 *     name="Admin / Waypoints",
 *     description="Admin API Endpoints of Waypoints"
 * )
 *
 * @OA\Tag(
 *     name="Admin / Geolocation",
 *     description="Admin API Endpoints for Geolocation"
 * )
 *
 * @OA\Tag(
 *     name="Itineraries",
 *     description="API Endpoints of Itineraries"
 * )
 *
 * @OA\Tag(
 *     name="Waypoints",
 *     description="API Endpoints of Waypoints"
 * )
 *
 * @OA\Tag(
 *     name="Geolocation",
 *     description="API Endpoints for Geolocation"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="Authorization",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="string",
 * ),
 *
 * @OA\Schema(
 *   schema="product_id",
 *   type="integer",
 *   format="int64",
 *   description="The unique identifier of a product in our catalog"
 * ),
 *
 * @OA\Response(
 *     response="200Success",
 *     description="Success",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="201Created",
 *     description="Success",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="202Accepted",
 *     description="Accepted",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="204NoContent",
 *     description="No Content",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="400BadRequest",
 *     description="Bad Request",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="401NotAuthorized",
 *     description="Not Authorized",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="404NotFound",
 *     description="Not Found",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 * @OA\Response(
 *     response="422UnprocessableEntity",
 *     description="Unprocessable Entity",
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json"
 *         )
 *      }
 * ),
 *
 * @OA\Server(url=L5_SWAGGER_CONST_HOST),
 */

namespace Mchljams\TravelLog\Http\Controllers\API;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mchljams\TravelLog\Http\Middleware\ApiHeaders;

class BaseController extends Controller
{
    protected $user;

    protected $isAdmin = false;

    private $response;

    public function __construct()
    {
        $this->middleware(ApiHeaders::class);

        if(Auth::guard('admin_api')->check()) {
            $this->user = Auth::guard('admin_api')->user();
            $this->isAdmin = true;
        } elseif(Auth::guard('api')->check()) {
            $this->user = Auth::guard('api')->user();
            $this->isAdmin = false;
        } else {
            return response()->json([
                'message' => 'Not Authorized',
            ], 401);
        }
    }


    protected function setResponse($statusCode, $data = null, $statusMessage = null)
    {
        $statusMessage = ($statusMessage == null) ? Response::$statusTexts[$statusCode] : $statusMessage;

        $body = [];

        $body['message'] = $statusMessage;

        if(!is_null($data)) {
            $body['data'] = $data;
        }

        $this->response = response()->json($body, $statusCode);

        return $this;
    }

    protected function respond()
    {
        return $this->response;
    }


    protected function log($action, $message, $level = 'info') {
        Log::{$level}('', array(
            'action' => $action,
            'user' => $this->user->id
        ));
    }
}
