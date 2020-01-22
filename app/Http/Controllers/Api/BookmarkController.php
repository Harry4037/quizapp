<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestSeries;
use App\Models\Bookmark;
use App\Models\Subject;

class BookmarkController extends Controller
{

    /**
     * @api {post} /api/add-bookmark  Bookmark
     * @apiHeader {String} Accept application/json.
     * @apiName PostBookmark
     * @apiGroup Bookmark
     *
     * @apiParam {String} user_id User user_id*.
     * @apiParam {String} test_series_id Test Series Id.
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
        if (!$request->test_series_id) {
            return $this->errorResponse("test_series Id missing.");
        }
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
            return $this->successResponse("test_series bookmarked successfully.", $arr);
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
     *            "total_question": 556,
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
            $bookmarks = Bookmark::where("user_id", $request->user_id)->with(['testseriesDetail'])->get();
            foreach ($bookmarks as $key => $bookmark) {
                $bookmarkArray[$key]['id'] = $bookmark->id;
                $bookmarkArray[$key]['test_series_id'] = $bookmark->testseriesDetail->id;
                $bookmarkArray[$key]['created_at'] = $bookmark->created_at;
                $bookmarkArray[$key]['subject_id'] = $bookmark->testseriesDetail->subject_id;
                $bookmarkArray[$key]['name'] = $bookmark->testseriesDetail->name;
                $bookmarkArray[$key]['total_question'] = $bookmark->testseriesDetail->total_question;
                $bookmarkArray[$key]['lang'] = $bookmark->testseriesDetail->lang;
                $subject = Subject::where("id", $bookmark->testseriesDetail->subject_id)->first();
                $bookmarkArray[$key]['subject_name'] = $subject->name;
            }
            $data['Bookmark_list'] = $bookmarkArray;
            return $this->successResponse("Bookmark List.", $data);
        }
    }
}