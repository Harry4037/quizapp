<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\UserQuestionLike;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAnswer;
use App\Models\Answer;
use App\Models\TestSeries;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\UserTestSeries;
use App\Models\UserTestSeriesQuestionAnswer;
use App\Models\User;

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
     * @apiParam {String} year year(optional)*.
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
     *          "question_time":50,
     *          "test_series_id":2,
     *          "questions": {
     *               "id": 8,
     *               "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *               "ques_image": " ",
     *               "ques_time": 20,
     *               "is_like" : true,
     *                "user": {
     *                   "id": 2,
     *                   "name": "manish",
     *                   "profile_pic": ""
     *                },
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
     *               "is_like" : true,
     *                "user": {
     *                   "id": 2,
     *                   "name": "manish",
     *                   "profile_pic": ""
     *                },
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
//        if (!$request->user_id) {
//            return $this->errorResponse("User ID is missing.");
//        }
        $user = User::find($request->user_id);
//        if (!$user) {
//            return $this->errorResponse("Invalid User.");
//        }
        if ($request->flag == 1) {
            $questions = Question::where("lang", $user ? $user->lang : 0)->limit(500)->get();
            if (count($questions) > 10) {
                $questions = $questions->random(10);
            }
            $dataArray = [];
            $totatlTime = 0;
            foreach ($questions as $k => $question) {
                $answers = Answer::where("question_id", $question->id)->get();
                $isLike = UserQuestionLike::where(["question_id" => $question->id, "user_id" => $request->user_id])->first();
                $user = User::find($question->user_id);
                $dataArray[$k]['id'] = $question->id;
                $dataArray[$k]['user']['id'] = $user ? $user->id : 0;
                $dataArray[$k]['user']['name'] = $user ? $user->name : '';
                $dataArray[$k]['user']['profile_pic'] = $user ? $user->profile_pic : '';
                $dataArray[$k]['description'] = $question->description;
                $dataArray[$k]['ques_image'] = $question->ques_image;
                $dataArray[$k]['ques_time'] = $question->ques_time;
                $dataArray[$k]['is_like'] = $isLike ? true : false;
                $dataArray[$k]['answers'] = $answers;
                $totatlTime += $question->ques_time;
            }
            $data['question_time'] = $totatlTime;
            $data['questions'] = $dataArray;
            return $this->successResponse("Question list.", $data);
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
            $query->where(function($query) use($request) {
                $query->where("lang", $request->lang)
                        ->whereIn('exam_id', $request->exam_id)
                        ->whereIn('subject_id', $request->subject_id);
            });
            $query->limit($request->total_questions);
            if (!$request->year) {
                $questions = $query->get();
            } else {
                $questions = $query->where('year', $request->year)->get();
            }


            $dataArray = [];
            $totatlTime = 0;
            foreach ($questions as $k => $question) {
                $answers = Answer::where("question_id", $question->id)->get();
                $isLike = UserQuestionLike::where(["question_id" => $question->id, "user_id" => $request->user_id])->first();
                $dataArray[$k]['id'] = $question->id;
                $dataArray[$k]['description'] = $question->description;
                $dataArray[$k]['ques_image'] = $question->ques_image;
                $dataArray[$k]['ques_time'] = $question->ques_time;
                if ($request->year) {
                    $dataArray[$k]['year'] = $question->year;
                }
                $dataArray[$k]['is_like'] = $isLike ? true : false;
                $dataArray[$k]['answers'] = $answers;
                $totatlTime += $question->ques_time;
            }

            $data['question_time'] = $totatlTime;
            $data['questions'] = $dataArray;


            $testSeries = new UserTestSeries();
            $testSeries->user_id = $request->user_id;
            $exam_name = Exam::where('id', $request->exam_id)->first();
            $testSeries->name = $exam_name->name . "_" . $request->id;
            $testSeries->exam_id = $request->exam_id[0];
            $testSeries->subject_id = $request->subject_id[0];
            $testSeries->lang = $request->lang;
            $testSeries->is_attempted = 0;
            if ($testSeries->save()) {
                foreach ($questions as $k => $question) {
                    $UserTestSeriesQuestionAnswer = new UserTestSeriesQuestionAnswer();
                    $UserTestSeriesQuestionAnswer->user_id = $request->user_id;
                    $UserTestSeriesQuestionAnswer->user_test_series_id = $testSeries->id;
                    $UserTestSeriesQuestionAnswer->question_id = $question->id;
                    $UserTestSeriesQuestionAnswer->answer_id = NULL;
                    $UserTestSeriesQuestionAnswer->is_correct = NULL;
                    $UserTestSeriesQuestionAnswer->status = 0;
                    $UserTestSeriesQuestionAnswer->save();
                }
            }
            $data['test_series_id'] = $testSeries->id;
            return $this->successResponse("Question list.", $data);
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
     * @apiExample Example usage:
     * body:
     *   {
     *           "user_id":1,
     *           "quiz_id":2,
     *           "name" : "SSC_1",
     *           "exam_id":1,
     *           "subject_id":1,
     *           "lang":1,
     *           "questions":[
     *                   {
     *                           "question_id":1,
     *                           "answer_id":4,
     *                           "is_correct":1
     *                   },
     *                   {
     *                           "question_id":2,
     *                           "answer_id":6,
     *                           "is_correct":0
     *                   }
     *           ]
     *   }
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
     *       "data": {
     *           "test_series": {
     *               "name": "SSC_1",
     *               "your_score": 1,
     *               "total_score": 2,
     *               "your_rank": "2300",
     *               "total_rank": "5000",
     *               "questions": [
     *                   {
     *                       "question": {
     *                           "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *                           "ques_image": " "
     *                       },
     *                       "your_answer_id": 4,
     *                       "answers": [
     *                           {
     *                               "id": 1,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 2,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 3,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 4,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 1
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "question": {
     *                           "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
     *                           "ques_image": " "
     *                       },
     *                       "your_answer_id": 6,
     *                       "answers": [
     *                           {
     *                               "id": 5,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 6,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 7,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 0
     *                           },
     *                           {
     *                               "id": 8,
     *                               "description": "Lorem Ipsum.",
     *                               "is_answer": 1
     *                           }
     *                       ]
     *                   }
     *               ]
     *           }
     *       }
     *   }
     *
     */
    public function submitQuestion(Request $request) {
        if (empty($request->input())) {
            return $this->errorResponse("Parameter Body Missing.");
        }
//        dd();
        if (!$request->input("user_id")) {
            return $this->errorResponse("User Id missing.");
        }
        if (!$request->input("quiz_id")) {
            return $this->errorResponse("Test Series Id missing.");
        }
        if (!$request->input("name")) {
            return $this->errorResponse("Name missing.");
        }
        if (!$request->input("exam_id")) {
            return $this->errorResponse("Exam Id missing.");
        }
        $exam = Exam::find($request->input("exam_id"));
        if (!$exam) {
            return $this->errorResponse("Exam not found.");
        }
        if (!$request->input("subject_id")) {
            return $this->errorResponse("Exam Id missing.");
        }
        $subject = Subject::find($request->input("subject_id"));
        if (!$subject) {
            return $this->errorResponse("Subject not found.");
        }
        if (!$request->input("lang")) {
            return $this->errorResponse("Language missing.");
        }
        if (!in_array($request->input("lang"), [1, 2])) {
            return $this->errorResponse("Invalid Language Type.");
        }
        if (!$request->input("questions")) {
            return $this->errorResponse("Questions missing.");
        }
        if (!is_array($request->input("questions"))) {
            return $this->errorResponse("Questions missing.");
        }
        try {
            $UserTestSeries = UserTestSeries::find($request->quiz_id);
//            $UserTestSeries = new UserTestSeries();
            $UserTestSeries->user_id = $request->input("user_id");
            $UserTestSeries->name = $request->input("name");
            $UserTestSeries->exam_id = $request->input("exam_id");
            $UserTestSeries->subject_id = $request->input("subject_id");
            $UserTestSeries->lang = $request->input("lang");
            $UserTestSeries->is_attempted = 1;
            if ($UserTestSeries->save()) {
                $total = 0;
                $correct = 0;
                $questions = [];
                foreach ($request->input("questions") as $k => $question) {
                    $UserTestSeriesQuestionAnswer = UserTestSeriesQuestionAnswer::where(["user_test_series_id" => $UserTestSeries->id, "question_id" => $question['question_id']])->first();
//                    $UserTestSeriesQuestionAnswer = new UserTestSeriesQuestionAnswer();
//                    $UserTestSeriesQuestionAnswer->user_test_series_id = $UserTestSeries->id;
//                    $UserTestSeriesQuestionAnswer->question_id = $question['question_id'];
                    $UserTestSeriesQuestionAnswer->answer_id = $question['answer_id'];
                    $UserTestSeriesQuestionAnswer->status = 1;
                    $UserTestSeriesQuestionAnswer->is_correct = $question['is_correct'];
                    $UserTestSeriesQuestionAnswer->save();
                    $questionDetail = Question::find($question['question_id']);
                    $answers = Answer::where("question_id", $question['question_id'])->get();
                    $questions[$k]['question']['description'] = $questionDetail->description;
                    $questions[$k]['question']['ques_image'] = $questionDetail->ques_image;

                    $questions[$k]['your_answer_id'] = $question['answer_id'];
                    if ($answers) {
                        foreach ($answers as $j => $answer) {
                            $questions[$k]['answers'][$j]['id'] = $answer->id;
                            $questions[$k]['answers'][$j]['description'] = $answer->description;
                            $questions[$k]['answers'][$j]['is_answer'] = $answer->is_answer;
                        }
                    }
                    if ($UserTestSeriesQuestionAnswer->is_correct == 1) {
                        $correct++;
                    }
                    $total++;
                }
                $dataArray['test_series']['name'] = $UserTestSeries->name;
                $dataArray['test_series']['your_score'] = $correct;
                $dataArray['test_series']['total_score'] = $total;
                $dataArray['test_series']['your_rank'] = "2300";
                $dataArray['test_series']['total_rank'] = "5000";
                $dataArray['test_series']['questions'] = $questions;


                return $this->successResponse("Answer's submitted succeffully.", $dataArray);
            } else {
                return $this->errorResponse("Something went wrong.");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
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

//    public function createQuestion(Request $request) {
//        if (!$request->description) {
//            return $this->errorResponse("description missing");
//        }
//        if (!$request->ans1) {
//            return $this->errorResponse("description missing");
//        }
//        if (!$request->ans2) {
//            return $this->errorResponse("description missing");
//        }
//        if (!$request->ans3) {
//            return $this->errorResponse("description missing");
//        }
//        if (!$request->ans4) {
//            return $this->errorResponse("description missing");
//        }
//        if (!$request->correct_ans) {
//            return $this->errorResponse("Correct Answer missing");
//        }
//        if (!$request->ques_time) {
//            return $this->errorResponse("Question Time missing");
//        }
//        if (!$request->test_series_id) {
//            return $this->errorResponse("Test Series Id missing");
//        }
//        $testSeries = TestSeries::find($request->test_series_id);
//        if (!$testSeries) {
//            return $this->errorResponse("Test Series not found.");
//        }
////        if (!$request->subject_id) {
////            return $this->errorResponse("subject ID missing");
////        }
//        $question = new Question();
//        if ($request->ques_pic) {
//            if (!$request->hasFile("ques_pic")) {
//                return $this->errorResponse("Question pic not valid file type.");
//            }
//            $ques_image = $request->file("ques_pic");
//            $ques = Storage::disk('public')->put('ques_pic', $ques_image);
//            $ques_file_name = basename($ques);
//            $question->ques_image = $ques_file_name;
//        } else {
//            $question->ques_image = NULL;
//        }
//        $question->exam_id = $testSeries->exam_id;
//        $question->user_id = $testSeries->user_id;
//        $question->description = $request->description;
//        $question->ques_time = $request->ques_time;
//        $question->subject_id = $testSeries->subject_id;
//        $question->test_series_id = $request->test_series_id;
//        if ($question->save()) {
//            for ($i = 1; $i <= 4; $i++) {
//                $answer = new Answer();
//                $answer->question_id = $question->id;
//                $answer->description = $request->ans . $i;
//                if ($request->correct_ans == "ans" . $i) {
//                    $answer->is_answer = 1;
//                } else {
//                    $answer->is_answer = 0;
//                }
//                $answer->save();
//            }
//            return $this->successResponse("Question Added successfully", (object) []);
//        } else {
//            return $this->errorResponse("Something went wrong.");
//        }
//    }

    /**
     * @api {post} /api/create-single-question  Create Single Question
     * @apiHeader {String} Accept application/json.
     * @apiName PostCreateSingleQuestion
     * @apiGroup Question/Answer
     *
     * @apiParam {String} user_id User ID.
     * @apiParam {String} exam_id Exam.
     * @apiParam {String} subject_id Subject.
     * @apiParam {String} lang language(1 => English,2 => Hindi) .
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
     *       "message": "Question added successfully",
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
    public function createSingleQuestion(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing");
        }
        if (!$request->subject_id) {
            return $this->errorResponse("Subject ID missing");
        }
        if (!$request->exam_id) {
            return $this->errorResponse("Exam ID missing");
        }
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
        if (!$request->lang) {
            return $this->errorResponse("Language missing");
        }
        if (!in_array($request->lang, [1, 2])) {
            return $this->errorResponse("Language Type missing");
        }
        $subject = Subject::find($request->subject_id);
        if (!$subject) {
            return $this->errorResponse("subject not found.");
        }
        $exam = Exam::find($request->exam_id);
        if (!$exam) {
            return $this->errorResponse("Exam not found.");
        }
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
        $question->lang = $request->lang;
        $question->user_id = $request->user_id;
        $question->exam_id = $exam->id;
        $question->description = $request->description;
        $question->ques_time = $request->ques_time;
        $question->subject_id = $subject->id;
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

    /**
     * @api {get} /api/year-list  Year List
     * @apiHeader {String} Accept application/json.
     * @apiName GetYearList
     * @apiGroup Question
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message List of Years.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "List of Years",
     *       "data": [
     *           {
     *               "year": 2013
     *           },
     *           {
     *               "year": 2019
     *           }
     *       ]
     *   }
     *
     *
     */
    public function yearList(Request $request) {
        $years = Question::whereNotNull('year')->groupBy('year')->select('year')->get();
        return $this->successResponse("List of Years", $years);
    }

    /**
     * @api {post} /api/submit-random-answer  Submit Random Answer
     * @apiHeader {String} Accept application/json.
     * @apiName PostSubmitRandomAnswer
     * @apiGroup Question/Answer
     *
     * @apiExample Example usage:
     * body:
     *   {
     *           "user_id":1,
     *           "questions":[
     *                   {
     *                           "question_id":1,
     *                           "answer_id":4,
     *                           "is_correct":1
     *                   },
     *                   {
     *                           "question_id":2,
     *                           "answer_id":6,
     *                           "is_correct":0
     *                   }
     *           ]
     *   }
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
     *
     */
    public function submitRandomQuestion(Request $request) {
        if (empty($request->input())) {
            return $this->errorResponse("Parameter Body Missing.");
        }
        if (!$request->input("user_id")) {
            return $this->errorResponse("Questions missing.");
        }
        if (!$request->input("questions")) {
            return $this->errorResponse("Questions missing.");
        }
        if (!is_array($request->input("questions"))) {
            return $this->errorResponse("Questions missing.");
        }
        foreach ($request->input("questions") as $k => $question) {
            $UserAnswer = new UserAnswer();
            $UserAnswer->user_id = $request->user_id;
            $UserAnswer->question_id = $question['question_id'];
            $UserAnswer->answer_id = $question['answer_id'];
            $UserAnswer->is_correct = $question['is_correct'];
            $UserAnswer->save();
        }

        return $this->successResponse("Result Submmitted Successfully.", (object) []);
    }

}
