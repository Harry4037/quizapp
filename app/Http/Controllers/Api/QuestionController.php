<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\UserQuestionLike;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\Answer;
use App\Models\TestSeries;

class QuestionController extends Controller {

    /**
     * @api {get} /api/question-list  Question list
     * @apiHeader {String} Accept application/json.
     * @apiName GetQuestionlist
     * @apiGroup Question/Answer
     *
     * @apiParam {String} user_id User ID.
     * @apiParam {String} flag Flag*.(1=>Random question, 2=> Filtered Question)
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
        if (!$request->flag) {
            return $this->errorResponse("Flag is missing.");
        }

        if ($request->flag == 1) {
            $questions = Question::all()->random(10);
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
        } elseif ($request->flag == 2) {
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
            // $query->whereIn('exam_id', $request->exam_id)
            $query->whereIn('subject_id', $request->subject_id);

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
        } else {
            return $this->errorResponse("Invlaid flag type.");
        }
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

    /**
     * @api {post} /api/create-question  Create Question
     * @apiHeader {String} Accept application/json.
     * @apiName PostCreateQuestion
     * @apiGroup Question/Answer
     *
     * @apiParam {String} description Description.
     * @apiParam {String} ques_time Question Time.
     * @apiParam {String} test_series_id Test Series Id.
     * @apiParam {String} ques_image Question Image*.
     * @apiParam {String} ans1 First Answer.
     * @apiParam {String} ans2 Second Answer.
     * @apiParam {String} ans3 Third Answer.
     * @apiParam {String} ans4 Fourth Answer.
     * @apiParam {String} Correct_ans Correct Answer (ans1,ans2,ans3,an4).
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Create test series.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Test Series Created successfully",
     *       "data": {}
     *   }
     *
     * @apiError descriptionMissing The Description missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "description missing.",
     *     "data": {}
     *  }
     *
     * @apiError questionTimeMissing The Question Time missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Question Time missing",
     *     "data": {}
     *  }
     *
     * @apiError testSeriesIdMissing The Test Series Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Test Series Id missing",
     *     "data": {}
     *  }
     *
     * @apiError subjectIdmissing The SubjectId missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Subject Id missing",
     *     "data": {}
     *  }
     *
     * @apiError QuestionPicNot validtype Question pic not valid file type.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Question pic not valid file type.",
     *     "data": {}
     *  }
     *
     */
    public function createQuestion(Request $request) {
        if (!$request->description) {
            return $this->errorResponse("description missing");
        }
        if (!$request->ans1) {
            return $this->errorResponse("description missing");
        }
        if (!$request->ans2) {
            return $this->errorResponse("description missing");
        }
        if (!$request->ans3) {
            return $this->errorResponse("description missing");
        }
        if (!$request->ans4) {
            return $this->errorResponse("description missing");
        }
        if (!$request->correct_ans) {
            return $this->errorResponse("Correct Answer missing");
        }
        if (!$request->ques_time) {
            return $this->errorResponse("Question Time missing");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series Id missing");
        }
        $testSeries = TestSeries::find($request->test_series_id);
        if (!$testSeries) {
            return $this->errorResponse("Test Series not found.");
        }
//        if (!$request->subject_id) {
//            return $this->errorResponse("subject ID missing");
//        }
        $question = new Question();
        if ($request->ques_pic) {
            if (!$request->hasFile("ques_pic")) {
                return $this->errorResponse("Question pic not valid file type.");
            }
            $ques_image = $request->file("ques_pic");
            $ques = Storage::disk('public')->put('ques_pic', $ques_image);
            $ques_file_name = basename($ques);
            $question->ques_image = $ques_file_name;
        } else {
            $question->ques_image = NULL;
        }
        $question->exam_id = $testSeries->exam_id;
        $question->description = $request->description;
        $question->ques_time = $request->ques_time;
        $question->subject_id = $testSeries->subject_id;
        $question->test_series_id = $request->test_series_id;
        if ($question->save()) {
            for ($i = 1; $i <= 4; $i++) {
                $answer = new Answer();
                $answer->question_id = $question->id;
                $answer->description = $request->ans . $i;
                if ($request->correct_ans == "ans" . $i) {
                    $answer->is_answer = 1;
                } else {
                    $answer->is_answer = 0;
                }
                $answer->save();
            }
            return $this->successResponse("Question Added successfully", (object) []);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }

}
