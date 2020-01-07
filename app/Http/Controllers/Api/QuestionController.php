<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\UserQuestionLike;
use App\Models\Question;

class QuestionController extends Controller {

    /**
     * @api {get} /api/question-list  Question list
     * @apiHeader {String} Accept application/json. 
     * @apiName GetQuestionlist
     * @apiGroup Question/Answer
     * 
     * @apiParam {String} user_id User ID.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Question list.
     * @apiSuccess {JSON} data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Question list.",
     *       "data": [
     *           {
     *               "id": 8,
     *               "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *               "ques_image": " ",
     *               "ques_time": 20,
     *               "answers": [
     *                   {
     *                       "id": 29,
     *                       "question_id": 8,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 30,
     *                       "question_id": 8,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 31,
     *                       "question_id": 8,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 32,
     *                       "question_id": 8,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 1,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   }
     *               ]
     *           },
     *           {
     *               "id": 20,
     *               "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *               "ques_image": " ",
     *               "ques_time": 20,
     *               "answers": [
     *                   {
     *                       "id": 77,
     *                       "question_id": 20,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 78,
     *                       "question_id": 20,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 79,
     *                       "question_id": 20,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 80,
     *                       "question_id": 20,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 1,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     * 
     */
    public function questionList(Request $request) {
        $questions = Question::all()->random(2);
        $dataArray = [];
        foreach ($questions as $k => $question) {
            $answers = Answer::where("question_id", $question->id)->get();
            $dataArray[$k]['id'] = $question->id;
            $dataArray[$k]['description'] = $question->description;
            $dataArray[$k]['ques_image'] = $question->ques_image;
            $dataArray[$k]['ques_time'] = $question->ques_time;
            $dataArray[$k]['answers'] = $answers;
        }

        return $this->successResponse("Question list.", $dataArray);
    }

    /**
     * @api {post} /api/submit-answer  Submit Answer
     * @apiHeader {String} Accept application/json. 
     * @apiName PostSubmitAnswer
     * @apiGroup Question/Answer
     * 
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} question_id Question ID's in Array Format*.
     * @apiParam {String} answer_id Answer ID's in Array Format*.
     * @apiParam {String} is_correct IsCorrect in Array Format* (0=> Incorrect Answer, 1 => Correct Answer).
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Answer's submitted succeffully.
     * @apiSuccess {JSON} data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Answer's submitted succeffully.",
     *       "data": {}
     *   }
     * 
     */
    public function submitQuestion(Request $request) {

        if (!$request->user_id) {
            return $this->errorResponse("User Id missing.");
        }
        if (!$request->question_id) {
            return $this->errorResponse("Question Id's missing.");
        }
        if (!is_array($request->question_id)) {
            return $this->errorResponse("Question Id's not in proper format.");
        }
        if (!$request->answer_id) {
            return $this->errorResponse("Answer Id's missing.");
        }
        if (!is_array($request->answer_id)) {
            return $this->errorResponse("Answer Id's not in proper format.");
        }
        if (!is_array($request->is_correct)) {
            return $this->errorResponse("IsCorrect Id's not in proper format.");
        }

        $questionCount = count($request->question_id);
        $answerCount = count($request->answer_id);
        if ($questionCount != $answerCount) {
            return $this->errorResponse("Question array length and answer array length is not equal.");
        }

        foreach ($request->question_id as $k => $questionID) {
            $userAnswer = new UserAnswer();
            $userAnswer->user_id = $request->user_id;
            $userAnswer->question_id = $questionID;
            $userAnswer->is_correct = $request->is_correct[$k];
            $userAnswer->answer_id = $request->answer_id[$k];
            $userAnswer->save();
        }

        return $this->successResponse("Answer's submitted succeffully.", (object) []);
    }

    /**
     * @api {post} /api/like-question  Question Like
     * @apiHeader {String} Accept application/json. 
     * @apiName PostQuestionLike
     * @apiGroup Question/Answer
     * 
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} question_id Question ID*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} Question Liked.
     * @apiSuccess {JSON} data blank object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Question Liked.",
     *       "data": {}
     *   }
     * 
     */
    public function likeQuestion(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing.");
        }
        if (!$request->question_id) {
            return $this->errorResponse("Question ID missing.");
        }

        $userQuesLike = new UserQuestionLike();
        $userQuesLike->user_id = $request->user_id;
        $userQuesLike->question_id = $request->question_id;
        $userQuesLike->save();

        return $this->successResponse("Question Liked.", (object) []);
    }

}
