<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Question;
use App\Models\Answer;

class QuizController extends Controller {

    /**
     * @api {get} /api/start-quiz  Start Quiz
     * @apiHeader {String} Accept application/json. 
     * @apiName GetStartQuiz
     * @apiGroup Quiz
     * 
     * @apiParam {String} exam_id Exam Id in array format*.
     * @apiParam {String} subject_id Subject Id in array format*.
     * @apiParam {String} total_questions Total no. of questions*.
     * @apiParam {String} lang Language(English=>1,Hindi=>2)*.
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
     *       "message": "Question list",
     *       "data": [
     *           {
     *               "id": 1,
     *               "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *               "ques_image": " ",
     *               "ques_time": 20,
     *               "answers": [
     *                   {
     *                       "id": 1,
     *                       "question_id": 1,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 2,
     *                       "question_id": 1,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 3,
     *                       "question_id": 1,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 0,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 4,
     *                       "question_id": 1,
     *                       "description": "Lorem Ipsum.",
     *                       "is_answer": 1,
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   }
     *               ]
     *           },
     *       ]
     *   } 
     * 
     */
    public function startQuiz(Request $request) {
        if (!$request->exam_id) {
            return $this->errorResponse("Exam Id missing.");
        }
        if (!is_array($request->exam_id)) {
            return $this->errorResponse("Exam Id is not in proper format.");
        }
        if (!$request->subject_id) {
            return $this->errorResponse("Subject Id missing.");
        }
        if (!is_array($request->subject_id)) {
            return $this->errorResponse("Subject Id is not in proper format.");
        }
        if (!$request->total_questions) {
            return $this->errorResponse("Number of total questions are missing.");
        }
        if (!$request->lang) {
            return $this->errorResponse("Language Id is missing.");
        }
        if (!in_array($request->lang, [1, 2])) {
            return $this->errorResponse("Invalid language Id.");
        }

        $query = Question::Query();
        $query->whereIn('exam_id', $request->exam_id)
                ->whereIn('subject_id', $request->subject_id);

        $query->limit($request->total_questions);

        $questions = $query->get();

        $dataArray = [];
        foreach ($questions as $k => $question) {
            $answers = Answer::where("question_id", $question->id)->get();
            $dataArray[$k]['id'] = $question->id;
            $dataArray[$k]['description'] = $question->description;
            $dataArray[$k]['ques_image'] = $question->ques_image;
            $dataArray[$k]['ques_time'] = $question->ques_time;
            $dataArray[$k]['answers'] = $answers;
        }

        return $this->successResponse("Question list", $dataArray);
    }

    public function createQuiz(Request $request) {
        if(!$request->user_id){
            return $this->errorResponse("User ID missing.");
        }
        if(!$request->subject_id){
            return $this->errorResponse("Subject ID missing.");
        }
    }

}
