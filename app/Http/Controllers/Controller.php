<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function errorResponse($message) {
        return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => $message,
                    'data' => (object) []
        ]);
    }

    public function successResponse($message, $data) {
        return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => $message,
                    'data' => $data
        ]);
    }

}
