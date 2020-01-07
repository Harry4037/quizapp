<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\QuestionComment;
use App\Models\User;
use App\Models\Question;

class QuestionCommentController extends Controller {

    /**
     * @api {post} /api/comment  Comment
     * @apiHeader {String} Accept application/json.
     * @apiName PostComment
     * @apiGroup Question/Answer
     *
     * @apiParam {String} user_id User ID.
     * @apiParam {String} question_id Question ID.
     * @apiParam {String} comment Comment.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message comment.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Comment",
     *       "data": []
     *   }
     * @apiError UserIdMissing user id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "user id missing",
     *       "data": {}
     *   }
     *
     * @apiError QuestionIdMissing Question Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Question ID missing",
     *       "data": {}
     *   }
     *
     * @apiError CommentMissing Comment missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Comment missing",
     *       "data": {}
     *   }
     *
     * @apiError UserNotFound User Not Found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User not found.",
     *       "data": {}
     *   }
     *
     * @apiError QuestionNotFound Question Not Found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Question not found.",
     *       "data": {}
     *   }
     *
     */
    public function comment(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("user id missing");
        }
        if (!$request->question_id) {
            return $this->errorResponse("Question ID missing");
        }
        if (!$request->comment) {
            return $this->errorResponse("Comment missing");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User not found.");
        }
        $question = Question::find($request->question_id);
        if (!$question) {
            return $this->errorResponse("Question not found.");
        }
        $comment = new QuestionComment();
        $comment->user_id = $request->user_id;
        $comment->question_id = $request->question_id;
        $comment->description = $request->comment;
        if ($comment->save()) {
            return $this->successResponse("Comment successfully", (object) []);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }

    /**
     * @api {get} /api/comment-list  Comment List
     * @apiHeader {String} Accept application/json.
     * @apiName GetCommentList
     * @apiGroup Question/Answer
     *
     * @apiParam {String} question_id Question ID.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message comment list.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *          "status":true,
     *          "status_code":200,
     *          "message":"List of Comments",
     *          "data":[
     *                 {
     *                  "id":3,
     *                  "user_id":2,
     *                  "question_id":5,
     *                  "description":"htrh",
     *                  "created_at":"2020-01-07 10:26:42",
     *                  "updated_at":"2020-01-07 10:26:42"
     *                  },
     *                  {
     *                      "id":4,
     *                      "user_id":2,
     *                      "question_id":5,
     *                      "description":"nice",
     *                      "created_at":"2020-01-07 10:27:18",
     *                      "updated_at":"2020-01-07 10:27:18"
     *          }
     *      ]
     *  }
     *
     *
     * @apiError QuestionNotFound Question Not Found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Question not found.",
     *       "data": {}
     *   }
     *
     */
    public function commentList(Request $request) {
        if (!$request->question_id) {
            return $this->errorResponse("Question ID missing");
        }
        $question = Question::find($request->question_id);
        if (!$question) {
            return $this->errorResponse("Question not found.");
        }

        $comment = QuestionComment::where('question_id',$request->question_id)->get();
        return $this->successResponse("List of Comments", $comment);

    }

}
