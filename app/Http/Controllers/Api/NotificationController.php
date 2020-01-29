<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
class NotificationController extends Controller {
    /**
     * @api {get} /api/notification  Notification
     * @apiHeader {String} Accept application/json.
     * @apiName GetNotification
     * @apiGroup Notification
     *
     * @apiParam {String} user_id User ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message notification.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Notification List",
     *    "data": {
     *        "notification_list": [
     *        {
     *            "id": 1,
     *            "user_id": 1,
     *            "message": "notification",
     *            "is_read": 1,
     *        }
     *      ]
     *   }
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
    public function notificationlist(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("user not found.");
        } else {
            $dataArray = [];
            $uy = Notification::where('user_id', $request->user_id)->latest()->get();
            if ($uy) {
                foreach ($uy as $key => $uuy) {
                    Notification::where('id', $uuy->id)->update(['is_read' => 1]);
                }
            }
            if ($uy) {
                foreach ($uy as $k => $uuy) {
                    $dataArray[$k]['id'] = $uuy->id;
                    $dataArray[$k]['user_id'] = $uuy->user_id;
                    $dataArray[$k]['is_read'] = $uuy->is_read;
                    $dataArray[$k]['message'] = $uuy->message;
                    $date = Carbon::parse($uuy->created_at);
                    $dataArray[$k]['date'] = $date->format("d-M-Y");
                    $dataArray[$k]['time'] = $date->format("h:i A");
                }
            }
            $data['notification_list']=$dataArray;
            return $this->successResponse("Notification List", $data);
        }
    }
}
