<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\quiz;

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

    /**
     * @api {post} /api/create-quiz  Create Quiz
     * @apiHeader {String} Accept application/json. 
     * @apiName PostCreateQuiz
     * @apiGroup Quiz
     * 
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} name Quiz Name*.
     * @apiParam {String} total_questions Total no. of questions*.
     * @apiParam {String} start_date_time Start Date Time (YYYY-MM-DD H:i)*.
     * @apiParam {String} end_date_time End Date Time (YYYY-MM-DD H:i)*.
     * @apiParam {String} lang Language(English=>1,Hindi=>2)*.
     * 
     * @apiSuccess {String} success true 
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed). 
     * @apiSuccess {String} message Quiz Created.
     * @apiSuccess {JSON} data object.
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Quiz create successfully.",
     *       "data": {
     *           "user_id": "1",
     *           "name": "SSC QUIZ",
     *           "total_questions": "10",
     *           "start_date_time": "2020-01-08 01:00",
     *           "end_date_time": "2020-01-08 02:00",
     *           "lang": "1",
     *           "updated_at": "2020-01-08 06:56:01",
     *           "created_at": "2020-01-08 06:56:01",
     *           "id": 1
     *       }
     *   } 
     * 
     */
    public function createQuiz(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing.");
        }
        if (!$request->name) {
            return $this->errorResponse("Name Missing.");
        }
        if (!$request->total_questions) {
            return $this->errorResponse("Total No. of Questions Missing.");
        }
        if (!$request->start_date_time) {
            return $this->errorResponse("Start Date Time Missing.");
        }
        if (!$request->end_date_time) {
            return $this->errorResponse("End Date Time Missing.");
        }
        if (!$request->lang) {
            return $this->errorResponse("Language Missing.");
        }
        if (!in_array($request->lang, [1, 2])) {
            return $this->errorResponse("Invalid Language Type Missing.");
        }
        try {
            $quiz = new quiz();
            $quiz->user_id = $request->user_id;
            $quiz->name = $request->name;
            $quiz->total_questions = $request->total_questions;
            $quiz->start_date_time = $request->start_date_time;
            $quiz->end_date_time = $request->end_date_time;
            $quiz->lang = $request->lang;
            $quiz->save();

            return $this->successResponse("Quiz create successfully.", $quiz);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

}
