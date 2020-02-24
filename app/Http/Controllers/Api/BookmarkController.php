<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestSeries;
use App\Models\Bookmark;
use App\Models\Subject;
use App\Models\UserTestSeries;
use App\Models\Question;
use App\Models\UserTestSeriesQuestionAnswer;

class BookmarkController extends Controller {

    /**
     * @api {post} /api/add-bookmark  Bookmark
     * @apiHeader {String} Accept application/json.
     * @apiName PostBookmark
     * @apiGroup Bookmark
     *
     * @apiParam {String} user_id User user_id*.
     * @apiParam {String} test_series_id Test Series Id.
     * @apiParam {String} flag Flag type.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message test series bookmarked successfully.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Test Series bookmarked successfully.",
     *       "data": {
     *            "favorite": true,
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
     * @apiError test_seriesIdmissing test_series Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "test_series Id missing.",
     *       "data": {}
     *   }
     *
     * @apiError test_seriesnotfound test_series not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "test_series not found.",
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
     *       "message": "test_series bookmarked Removed.",
     *       "data": {
     *            "favorite": false,
     *            "count": 1
     *         }
     *   }
     *
     */
    public function addBookmark(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        if (!in_array($request->flag, [1, 2])) {
            return $this->errorResponse("Select valid flag type");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("test_series Id missing.");
        }
        if ($request->flag == 1) {
            $test_series = TestSeries::find($request->test_series_id);
            if (!$test_series) {
                return $this->errorResponse("test series not found.");
            }
            $user = User::find($request->user_id);
            $remove = Bookmark::where("user_id", $request->user_id)->where("test_series_id", $request->test_series_id)->first();
            if (!$user) {
                return $this->errorResponse("user not found.");
            } elseif ($remove) {
                $r = Bookmark::where("user_id", $request->user_id)->where("test_series_id", $request->test_series_id)->delete();
                $fav_count = Bookmark::where('test_series_id', $request->test_series_id)->count();
                // $dataArray['fav_count'] = $fav_count;
                $arr = array('favorite' => false, 'count' => $fav_count);
                if ($user && $user->device_token) {
                    $this->generateNotification($user->id, 1, "Quizz Application", "Test Series bookmarked Removed.");
                    $this->androidPushNotification(2, "Quizz Application", "Test Series bookmarked Removed.", $user->device_token, 0, $this->notificationCount($user->id), $user->id);
                }
                return $this->successResponse("test_series bookmarked Removed.", $arr);
            } else {
                $bookmark = new Bookmark();
                $bookmark->test_series_id = $request->test_series_id;
                $bookmark->user_id = $request->user_id;
                $bookmark->created_at = new \DateTime("now");
                $bookmark->save();
                $fav_count = Bookmark::where('test_series_id', $request->test_series_id)->count();
                // $dataArray['fav_count'] = $fav_count;
                $arr = array('favorite' => true, 'count' => $fav_count);
                if ($user && $user->device_token) {
                    $this->generateNotification($user->id, 1, "Quizz Application", "Test Series bookmarked successfully.");
                    $this->androidPushNotification(2, "Quizz Application", "Test Series bookmarked successfully.", $user->device_token, 0, $this->notificationCount($user->id), $user->id);
                }
                return $this->successResponse("test_series bookmarked successfully.", $arr);
            }
        }
        if ($request->flag == 2) {
            $test_series = UserTestSeries::find($request->test_series_id);
            if (!$test_series) {
                return $this->errorResponse("test series not found.");
            }
            $user = User::find($request->user_id);
            $remove = Bookmark::where("user_id", $request->user_id)->where("user_test_series_id", $request->test_series_id)->first();
            if (!$user) {
                return $this->errorResponse("user not found.");
            } elseif ($remove) {
                $r = Bookmark::where("user_id", $request->user_id)->where("user_test_series_id", $request->test_series_id)->delete();
                $fav_count = Bookmark::where('user_test_series_id', $request->test_series_id)->count();
                // $dataArray['fav_count'] = $fav_count;
                $arr = array('favorite' => false, 'count' => $fav_count);
                return $this->successResponse("test_series bookmarked Removed.", $arr);
            } else {
                $bookmark = new Bookmark();
                $bookmark->user_test_series_id = $request->test_series_id;
                $bookmark->user_id = $request->user_id;
                $bookmark->created_at = new \DateTime("now");
                $bookmark->save();
                $fav_count = Bookmark::where('user_test_series_id', $request->test_series_id)->count();
                // $dataArray['fav_count'] = $fav_count;
                $arr = array('favorite' => true, 'count' => $fav_count);
                return $this->successResponse("test_series bookmarked successfully.", $arr);
            }
        }
    }

    /**
     * @api {get} /api/bookmark-list  Bookmark List
     * @apiHeader {String} Accept application/json.
     * @apiName GetBookmarkList
     * @apiGroup Bookmark
     *
     * @apiParam {String} user_id User id
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Bookmark List.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *    {
     *      "status": true,
     *      "status_code": 200,
     *      "message": "Bookmark List.",
     *      "data": {
     *        "Bookmark_list": [
     *          {
     *            "id": 2,
     *            "test_series_id": 1,
     *            "created_at": null,
     *            "subject_id": 3,
     *            "name": "Lorem Ipsum is simply dummy text of the printing",
     *            "total_time": 60,
     *             "total_question": 556,
     *            "lang": 1,
     *            "subject_name": "ssc"
     *           }
     *         ]
     *      }
     *    }
     * @apiError UserIdismissing User Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User Id missing.",
     *       "data": {}
     *   }
     *
     * @apiError Usernotfound User not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User not found.",
     *       "data": {}
     *   }
     *
     */
    public function bookmarkList(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("user not found.");
        } else {

            $bookmarkArray = [];
            $bookmarkArray1 = [];
            $bookmarks = Bookmark::where("user_id", $request->user_id)->where('test_series_id', '!=', 0)->with(['testseriesDetail'])->get();
            foreach ($bookmarks as $key => $bookmark) {
                $totalTime = Question::where("test_series_id", $bookmark->testseriesDetail->id)->sum("ques_time");
                $bookmarkArray[$key]['id'] = $bookmark->id;
                $bookmarkArray[$key]['test_series_id'] = $bookmark->testseriesDetail->id;
                $bookmarkArray[$key]['created_at'] = $bookmark->created_at;
                $bookmarkArray[$key]['subject_id'] = $bookmark->testseriesDetail->subject_id;
                $bookmarkArray[$key]['name'] = $bookmark->testseriesDetail->name;
                $bookmarkArray[$key]['flag'] = 1;
                $bookmarkArray[$key]['total_question'] = $bookmark->testseriesDetail->total_question;
                $bookmarkArray[$key]['total_time'] = $totalTime == 0 ? 60 : (int) $totalTime;
                $bookmarkArray[$key]['lang'] = $bookmark->testseriesDetail->lang;
                $subject = Subject::where("id", $bookmark->testseriesDetail->subject_id)->first();
                $bookmarkArray[$key]['subject_name'] = $subject->name;
            }

            $userbookmarks = Bookmark::where("user_id", $request->user_id)->where('user_test_series_id', '!=', 0)->with(['usertestseriesDetail'])->get();
            foreach ($userbookmarks as $key => $bookmark) {
                $totalQuestion = UserTestSeriesQuestionAnswer::where("user_test_series_id", $bookmark->usertestseriesDetail->id)->count();
                $questionId = UserTestSeriesQuestionAnswer::where("user_test_series_id", $bookmark->usertestseriesDetail->id)->pluck("question_id", "question_id");
                $totalTime = Question::whereIn("id", $questionId)->sum("ques_time");
                $bookmarkArray1[$key]['id'] = $bookmark->id;
                $bookmarkArray1[$key]['test_series_id'] = $bookmark->usertestseriesDetail->id;
                $bookmarkArray1[$key]['created_at'] = $bookmark->created_at;
                $bookmarkArray1[$key]['subject_id'] = $bookmark->usertestseriesDetail->subject_id;
                $bookmarkArray1[$key]['name'] = $bookmark->usertestseriesDetail->name;
                $bookmarkArray1[$key]['flag'] = 2;
                if ($bookmark->usertestseriesDetail->is_attempted == 1) {
                    $bookmarkArray1[$key]['is_attempted'] = TRUE;
                } else {
                    $bookmarkArray[$key]['is_attempted'] = FALSE;
                }
                $bookmarkArray1[$key]['total_question'] = $totalQuestion;
                $bookmarkArray1[$key]['total_time'] = $totalTime == 0 ? 60 : (int) $totalTime;
                $bookmarkArray1[$key]['lang'] = $bookmark->usertestseriesDetail->lang;
                $subject = Subject::where("id", $bookmark->usertestseriesDetail->subject_id)->first();
                $bookmarkArray1[$key]['subject_name'] = $subject->name;
            }
            $res = array_merge($bookmarkArray, $bookmarkArray1);
            $data['Bookmark_list'] = $res;
            return $this->successResponse("Bookmark List.", $data);
        }
    }

}
