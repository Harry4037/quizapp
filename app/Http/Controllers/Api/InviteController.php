<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\User;
use App\Models\TestSeries;

class InviteController extends Controller
{

    /**
     * @api {post} /api/invite  Invite
     * @apiHeader {String} Accept application/json.
     * @apiName PostInvite
     * @apiGroup Invite
     *
     * @apiParam {String} user_id User user_id.
     * @apiParam {String} test_series_id Test Series Id.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} Invite .
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Invite successfully",
     *       "data": {
     *              test_series": "dgregr",
     *              user_detail": "gggggu"
     *              }
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
     * @apiError TestSeriesIdmissing Test Series Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Test Series Id Missing",
     *       "data": {}
     *   }
     *
     * @apiError TestSeriesnotfound Test Series not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Test Series not found.",
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
     */
    public function invite(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series ID missing");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User not found.");
        }
        $testseries = TestSeries::find($request->test_series_id);
        if (!$testseries) {
            return $this->errorResponse("Test Series not found.");
        }
        $invite = new Invite();
        $invite->user_id = $request->user_id;
        $invite->test_series_id = $request->test_series_id;
        if ($invite->save()) {
            $data['test_series'] = $user->name;
            $data['user_detail'] = $testseries->name;
            return $this->successResponse("Invite successfully", $data);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }


    /**
     * @api {get} /api/invite-status  Invite Status
     * @apiHeader {String} Accept application/json.
     * @apiName GetInviteStatus
     * @apiGroup Invite
     *
     * @apiParam {String} user_id User user_id*.
     * @apiParam {String} test_series_id Test Series Id.
     * @apiParam {String} status Status.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} Invite .
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Accepted",
     *       "data": {}
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Rejected",
     *       "data": {}
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
     * @apiError TestSeriesIdmissing Test Series Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Test Series Id Missing",
     *       "data": {}
     *   }
     *
     * @apiError TestSeriesnotfound Test Series not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Test Series not found.",
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
     */

    public function inviteStatus(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series ID missing");
        }
        if (!in_array($request->status, [1, 2])) {
            return $this->errorResponse("Select valid Status type");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User not found.");
        }
        $testseries = TestSeries::find($request->test_series_id);
        if (!$testseries) {
            return $this->errorResponse("Test Series not found.");
        }
        if($request->status == 2){
            $invite = Invite::where('user_id',$request->user_id)->where('test_series_id',$request->test_series_id)->update(['status' => 2]);
            return $this->successResponse("Accepted", (object) []);
        }
        if($request->status == 3){
            $invite = Invite::where('user_id',$request->user_id)->where('test_series_id',$request->test_series_id)->update(['status' => 3]);
            return $this->successResponse("Rejected", (object) []);
        }

    }
}
