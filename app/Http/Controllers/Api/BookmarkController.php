<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Question;
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
     * @apiParam {String} question_id Question_id.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Question bookmarked successfully.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Question bookmarked successfully.",
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
     * @apiError QuestionIdmissing Question Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Question Id missing.",
     *       "data": {}
     *   }
     *
     * @apiError Questionnotfound Question not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Question not found.",
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
     *       "message": "Question bookmarked Removed.",
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
        if (!$request->question_id) {
            return $this->errorResponse("Question Id missing.");
        }
        $Question = Question::find($request->question_id);
        if (!$Question) {
            return $this->errorResponse("Question not found.");
        }
        $user = User::find($request->user_id);
        $remove = Bookmark::where("user_id", $request->user_id)->where("question_id", $request->question_id)->first();
        if (!$user) {
            return $this->errorResponse("user not found.");
        } elseif ($remove) {
            $r = Bookmark::where("user_id", $request->user_id)->where("question_id", $request->question_id)->delete();
            $fav_count = Bookmark::where('question_id', $request->question_id)->count();
            // $dataArray['fav_count'] = $fav_count;
            $arr = array('favorite' => false, 'count' => $fav_count);
            return $this->successResponse("Question bookmarked Removed.", $arr);
        } else {
            $bookmark = new Bookmark();
            $bookmark->question_id = $request->question_id;
            $bookmark->user_id = $request->user_id;
            $bookmark->created_at = new \DateTime("now");
            $bookmark->save();
            $fav_count = Bookmark::where('question_id', $request->question_id)->count();
            // $dataArray['fav_count'] = $fav_count;
            $arr = array('favorite' => true, 'count' => $fav_count);
            return $this->successResponse("Question bookmarked successfully.", $arr);
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
     *            "question_id": 1,
     *            "question_id": 3,
     *            "created_at": null,
     *            "subject_id": 3,
     *            "description": "Lorem Ipsum is simply dummy text of the printing",
     *            "ques_image": 556,
     *            "ques_time": 10,
     *            "subject_detail": "ssc"
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
            $bookmarks = Bookmark::where("user_id", $request->user_id)->with(['questionDetail'])->get();
            foreach ($bookmarks as $key => $bookmark) {
                $bookmarkArray[$key]['id'] = $bookmark->id;
                $bookmarkArray[$key]['question_id'] = $bookmark->questionDetail->id;
                $bookmarkArray[$key]['created_at'] = $bookmark->created_at;
                $bookmarkArray[$key]['subject_id'] = $bookmark->questionDetail->subject_id;
                $bookmarkArray[$key]['description'] = $bookmark->questionDetail->description;
                $bookmarkArray[$key]['ques_image'] = $bookmark->questionDetail->ques_image;
                $bookmarkArray[$key]['ques_time'] = $bookmark->questionDetail->ques_time;
                $subject = Subject::where("id", $bookmark->questionDetail->subject_id)->first();
                $bookmarkArray[$key]['subject_detail'] = $subject->name;
            }
            $data['Bookmark_list'] = $bookmarkArray;
            return $this->successResponse("Bookmark List.", $data);
        }
    }
}
