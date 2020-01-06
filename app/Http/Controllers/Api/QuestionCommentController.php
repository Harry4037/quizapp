<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\QuestionComment;
use App\Models\User;
use App\Models\Question;

class QuestionCommentController extends Controller
{
    /**
     * @api {get} /api/comment  Comment
     * @apiHeader {String} Accept application/json.
     * @apiName GetComment
     * @apiGroup Question
     *
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
     * @apiGroup Question
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message comment list.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Comment",
     *       "data": [
     *           {
     *               "id": 1,
     *               "name": "English",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           },
     *           {
     *               "id": 2,
     *               "name": "Hindi",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           }
     *       ]
     *   }
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
        $subjects = QuestionComment::get();
        return $this->successResponse("List of Subjects", $subjects);
    }

}
