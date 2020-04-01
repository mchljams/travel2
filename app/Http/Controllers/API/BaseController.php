<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class BaseController extends Controller
{
    protected $user;

    protected $isAdmin = false;

    private $response;

    public function __construct()
    {
        if(Auth::guard('admin_api')->check()) {
            $this->user = Auth::guard('admin_api')->user();
            $this->isAdmin = true;
        } elseif(Auth::guard('api')->check()) {
            $this->user = Auth::guard('api')->user();
            $this->isAdmin = false;
        } else {
            return response()->json([
                'message' => 'Unauthorized',
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


    protected function log($action) {
        Log::info('', array(
            'action' => $action,
            'user' => $this->user->id
        ));
    }
}
