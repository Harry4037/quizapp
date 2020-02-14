<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
class FeedbackController extends Controller {
    /**
     * @api {get} /api/feedback  Feedback
     * @apiHeader {String} Accept application/json.
     * @apiName GetFeedback
     * @apiGroup CMS
     *
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} context message.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message about us found.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Feedback Sent.",
     *    "data": {}
     * }
     *
     * @apiError Useridmissing User Id missing
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User Id missing",
     *       "data": {}
     *   }
     *
     * @apiError Contextmissing Context missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Context missing.",
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
    public function addFeedback(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        if (!$request->context) {
            return $this->errorResponse("Context missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("user not found.");
        } else {
            $feedback = new Feedback();
            $feedback->user_id = $request->user_id;
            $feedback->description = $request->context;
            $feedback->created_at = new \DateTime("now");
            $feedback->save();
            return $this->successResponse("Feedback Sent.", (object)[]);
        }
    }
}
