<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{

     /**
     * @api {gwt} /api/follow  Follow
     * @apiHeader {String} Accept application/json.
     * @apiName GetFollow
     * @apiGroup Follow
     *
     * @apiParam {String} user_id User user_id*.
     * @apiParam {String} follow_user_id Follow User Id.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Following.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Following",
     *       "data": {
     *            "follow": true,
     *            "count": 1
     *         }
     *   }
     *
     * @apiError UserIdmissing User Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User Id missing.",
     *       "data": {}
     *   }
     *
     *
     * @apiError ProductIdmissing Product Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Follow User Id Missing",
     *       "data": {}
     *   }
     *
     * @apiError Productnotfound Product not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Follow User not found.",
     *       "data": {}
     *   }
     *
     * @apiError usernotfound user not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "user not found.",
     *       "data": {}
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Unfollow",
     *       "data": {
     *            "follow": false,
     *            "count": 1
     *         }
     *   }
     *
     */
    public function follow(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        if (!$request->follow_user_id) {
            return $this->errorResponse("Follow User Id missing.");
        }
        $follow_user_id = User::find($request->follow_user_id);
        if (!$follow_user_id) {
            return $this->errorResponse("Follow User not found.");
        }
        $user = User::find($request->user_id);
        $remove = Follow::where("user_id", $request->user_id)->where("follow_user_id", $request->follow_user_id)->first();
        if (!$user) {
            return $this->errorResponse("user not found.");
        } elseif ($remove) {
            $r = Follow::where("user_id", $request->user_id)->where("follow_user_id", $request->follow_user_id)->delete();
            $follow_count = Follow::where('follow_user_id', $request->follow_user_id)->count();
            $arr = array('follow' => false, 'count' => $follow_count);
            return $this->successResponse("Unfollow", $arr);
        } else {
            $Follow = new Follow();
            $Follow->follow_user_id = $request->follow_user_id;
            $Follow->user_id = $request->user_id;
            $Follow->created_at = new \DateTime("now");
            $Follow->save();
            $follow_count = Follow::where('follow_user_id', $request->follow_user_id)->count();
            $arr = array('follow' => false, 'count' => $follow_count);
            return $this->successResponse("Following", $arr);
        }
    }
}
