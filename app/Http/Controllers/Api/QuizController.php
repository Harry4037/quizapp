<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;
use App\Models\UserQuiz;
use App\Models\UserQuizQuestionAnswer;

class QuizController extends Controller {

    /**
     * @api {get} /api/quiz-detail  Quiz Detail
     * @apiHeader {String} Accept application/json.
     * @apiName GetQuizDetail
     * @apiGroup Quiz
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Daily Quiz Found.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Daily Quiz Found",
     *       "data": {
     *           "quiz": {
     *               "id": 1,
     *               "name": "ABC",
     *               "total_question": 10,
     *               "lang": "English",
     *               "start_date_time": "2020-01-23 16:00:00",
     *               "end_date_time": "2020-01-23 17:00:00"
     *           }
     *       }
     *   }
     *
     */
    public function quizDetail(Request $request) {
        $quiz = Quiz::whereDate('start_date_time', '=', date('Y-m-d'))->first();
        if ($quiz) {
            $dataArray = [];
            $dataArray['quiz']['id'] = $quiz->id;
            $dataArray['quiz']['name'] = $quiz->name;
            $dataArray['quiz']['total_question'] = $quiz->total_questions;
            $dataArray['quiz']['lang'] = $quiz->lang == 1 ? 'English' : 'Hindi';
            $dataArray['quiz']['start_date_time'] = $quiz->start_date_time;
            $dataArray['quiz']['end_date_time'] = $quiz->end_date_time;

            return $this->successResponse("Daily Quiz Found.", $dataArray);
        } else {
            return $this->errorResponse("No Daily Quiz Found.");
        }
    }

    /**
     * @api {get} /api/start-quiz  Start Quiz
     * @apiHeader {String} Accept application/json.
     * @apiName GetQuizQuestion
     * @apiGroup Quiz
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Daily Quiz Found.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Daily Quiz Found.",
     *       "data": {
     *           "quiz": {
     *               "id": 1,
     *               "name": "ABC",
     *               "total_question": 10,
     *               "lang": "English",
     *               "start_date_time": "2020-01-23 16:00:00",
     *               "end_date_time": "2020-01-23 17:00:00",
     *               "questions": [
     *                   {
     *                       "id": 1,
     *                       "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *                       "ques_image": "http://127.0.0.1:8000/storage/ques_image/ ",
     *                       "answers": [
     *                           {
     *                               "id": 1,
     *                               "question_id": 1,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0,
     *                               "created_at": null,
     *                               "updated_at": null,
     *                               "deleted_at": null
     *                           },
     *                           {
     *                               "id": 2,
     *                               "question_id": 1,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0,
     *                               "created_at": null,
     *                               "updated_at": null,
     *                               "deleted_at": null
     *                           },
     *                           {
     *                               "id": 3,
     *                               "question_id": 1,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0,
     *                               "created_at": null,
     *                               "updated_at": null,
     *                               "deleted_at": null
     *                           },
     *                           {
     *                               "id": 4,
     *                               "question_id": 1,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 1,
     *                               "created_at": null,
     *                               "updated_at": null,
     *                               "deleted_at": null
     *                           }
     *                       ]
     *                   }
     *               ]
     *           }
     *       }
     *   }
     *
     */
    public function startQuiz(Request $request) {
        $quiz = Quiz::whereDate('start_date_time', '=', date('Y-m-d'))->first();

        if ($quiz) {
            $startDateTime = Carbon::parse($quiz->start_date_time);
            $endDateTime = Carbon::parse($quiz->start_date_time)->addMinutes(5);
            $currentDateTime = Carbon::now();
            if ($currentDateTime->between($startDateTime, $endDateTime)) {
                $dataArray = [];
                $dataArray['quiz']['id'] = $quiz->id;
                $dataArray['quiz']['name'] = $quiz->name;
                $dataArray['quiz']['total_question'] = $quiz->total_questions;
                $dataArray['quiz']['lang'] = $quiz->lang == 1 ? 'English' : 'Hindi';
                $dataArray['quiz']['start_date_time'] = $quiz->start_date_time;
                $dataArray['quiz']['end_date_time'] = $quiz->end_date_time;
                $questions = Question::where('quiz_id', $quiz->id)->get();
                if ($questions) {
                    foreach ($questions as $k => $question) {
                        $answers = Answer::where('question_id', $question->id)->get();
                        $dataArray['quiz']['questions'][$k]['id'] = $question->id;
                        $dataArray['quiz']['questions'][$k]['description'] = $question->description;
                        $dataArray['quiz']['questions'][$k]['ques_image'] = $question->ques_image;
                        $dataArray['quiz']['questions'][$k]['answers'] = $answers;
                    }
                } else {
                    $dataArray['quiz']['questions'] = [];
                }
                return $this->successResponse("Daily Quiz Found.", $dataArray);
            } else {
                return $this->errorResponse("You can not participate in this quiz.");
            }
        } else {
            return $this->errorResponse("No Daily Quiz Found.");
        }
    }

    /**
     * @api {post} /api/submit-quiz  Submit Quiz
     * @apiHeader {String} Accept application/json.
     * @apiName PostSubmitQuiz
     * @apiGroup Quiz
     *
     * @apiExample Example usage:
     * body:
     *   {
     *           "user_id":1,
     *           "quiz_id":1,
     *           "questions":[
     *           {
     *             "question_id":1,
     *             "answer_id":4,
     *             "is_correct":1
     *           },
     *           {
     *             "question_id":2,
     *             "answer_id":6,
     *             "is_correct":0
     *           }
     *       ]
     *   }
     * 
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Daily Quiz Submitted.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Daily Quiz Submitted.",
     *       "data": {
     *          
     *        }
     *   }
     *
     */
    
    public function submitQuiz(Request $request) {
        if (empty($request->input())) {
            return $this->errorResponse("Parameter Body Missing.");
        }
        if (!$request->input("user_id")) {
            return $this->errorResponse("User Id missing.");
        }
        if (!$request->input("quiz_id")) {
            return $this->errorResponse("Quiz Id missing.");
        }

        if (!$request->input("questions")) {
            return $this->errorResponse("Questions missing.");
        }
        if (!is_array($request->input("questions"))) {
            return $this->errorResponse("Questions missing.");
        }
        try {
            $userQuiz = new UserQuiz();
            $userQuiz->user_id = $request->input("user_id");
            $userQuiz->quiz_id = $request->input("quiz_id");
            if ($userQuiz->save()) {
                foreach ($request->input("questions") as $question) {
                    $userQuizquestion = new UserQuizQuestionAnswer();
                    $userQuizquestion->user_quiz_id = $userQuiz->id;
                    $userQuizquestion->question_id = $question['question_id'];
                    $userQuizquestion->answer_id = $question['answer_id'];
                    $userQuizquestion->is_correct = $question['is_correct'];
                    $userQuizquestion->save();
                }
                return $this->successResponse("Quiz Submitted Succesfully", (object) []);
            } else {
                return $this->errorResponse("Something went wrong.");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }

}
