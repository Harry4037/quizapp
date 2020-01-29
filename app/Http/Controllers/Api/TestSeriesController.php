<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Question;
use App\Models\TestSeries;
use App\Models\Subject;
use App\Models\Answer;
use App\Models\Exam;
use Carbon\Carbon;
use App\Models\Bookmark;
use App\Models\Invite;
use App\Models\UserTestSeries;
use App\Models\SearchHistory;
use App\Models\UserTestSeriesQuestionAnswer;

class TestSeriesController extends Controller {

    /**
     * @api {post} /api/create-test-series  Create Test Series
     * @apiHeader {String} Accept application/json.
     * @apiName PostCreateTestSeries
     * @apiGroup TestSeries
     *
     * @apiExample Example usage:
     * body:
     *   {
     *           "user_id":1,
     *           "series_name" : "SSC_1",
     *           "exam_id":1,
     *           "subject_id":1,
     *           "question_count":10,
     *           "lang":1,
     *           "questions":[
     *                   {
     *                           "question_discription":"Detail of question",
     *                           "ans_1":"detail ans 1",
     *                           "ans_2":"detail ans 2",
     *                           "ans_3":"detail ans 3",
     *                           "ans_4":"detail ans 4",
     *                           "image_path":"sdafsadfasdfasdfs",
     *                           "correct_ans":1,
     *                           "time_per_question":1
     *                   }
     *           ]
     *   }
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Test Series Created successfully",
     *       "data": {
     *               "id": 1,
     *               "subject_id": 2,
     *               "subject_name": "ssc"
     *          }
     *   }
     *
     * @apiError userIDMissing The user id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User id missing.",
     *     "data": {}
     *  }
     *
     * @apiError testSeriesnameMissing The Test series name missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Test Series Name missing",
     *     "data": {}
     *  }
     *
     * @apiError totalnomissing The total no of question missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Total no missing",
     *     "data": {}
     *  }
     *
     * @apiError langmissing The language missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "lang missing",
     *     "data": {}
     *  }
     *
     * @apiError subjectidmissing The Subject Id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "subject ID missing",
     *     "data": {}
     *  }
     *
     * @apiError subjectnotfound The Subject not found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Subject not found.",
     *     "data": {}
     *  }
     *
     *
     *
     */
    public function createTestSeries(Request $request) {

        if (!$request->input()) {
            return $this->errorResponse("Body Json not found.");
        }
        if (!$request->input("user_id")) {
            return $this->errorResponse("User ID Missing.");
        }
        if (!$request->input("series_name")) {
            return $this->errorResponse("Series Name Missing.");
        }
        if (!$request->input("exam_id")) {
            return $this->errorResponse("Exam ID Missing.");
        }
        $exam = Exam::find($request->input("exam_id"));
        if (!$exam) {
            return $this->errorResponse("Invalid Exam ID");
        }
        if (!$request->input("subject_id")) {
            return $this->errorResponse("Subject ID Missing.");
        }
        $subject = Subject::find($request->input("subject_id"));
        if (!$subject) {
            return $this->errorResponse("Invalid Subject ID.");
        }
        if (!$request->input("question_count")) {
            return $this->errorResponse("Question Count Missing.");
        }
        if (!$request->input("lang")) {
            return $this->errorResponse("Language Missing.");
        }
        if (!in_array($request->input("lang"), [1, 2])) {
            return $this->errorResponse("Invalid Language Type.");
        }
        if (!$request->input("questions")) {
            return $this->errorResponse("Questions missing.");
        }

        $testSeries = new TestSeries();
        $testSeries->user_id = $request->input("user_id");
        $testSeries->exam_id = $request->input("exam_id");
        $testSeries->subject_id = $request->input("subject_id");
        $testSeries->name = $request->input("series_name");
        $testSeries->total_question = $request->input("question_count");
        $testSeries->lang = $request->input("lang");
        if ($testSeries->save()) {
            foreach ($request->input("questions") as $question) {
                $testSeriesQuestion = new Question();
                $testSeriesQuestion->user_id = $request->input("user_id");
                $testSeriesQuestion->exam_id = $request->input("exam_id");
                $testSeriesQuestion->subject_id = $request->input("subject_id");
                $testSeriesQuestion->description = $question["question_discription"];
                $testSeriesQuestion->ques_image = '';
                $testSeriesQuestion->ques_time = $question["time_per_question"];
                $testSeriesQuestion->test_series_id = $testSeries->id;
                if ($testSeriesQuestion->save()) {
                    for ($i = 1; $i <= 4; $i++) {
                        $kk = 'ans_' . $i;
                        $answer = new Answer();
                        $answer->question_id = $testSeriesQuestion->id;
                        $answer->description = $question[$kk];
                        if ($question['correct_ans'] == $i) {
                            $answer->is_answer = 1;
                        } else {
                            $answer->is_answer = 0;
                        }
                        $answer->save();
                    }
                }
            }
            $idd['test_series_id'] = $testSeries->id;
            return $this->successResponse("Test Series created succesfully.", $idd);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }

    /**
     * @api {get} /api/test-series-list Test Series List
     * @apiHeader {String} Accept application/json.
     * @apiName GetTestSeriesList
     * @apiGroup TestSeries
     *
     * @apiParam {String} user_id User ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message 1=>testseries, 2=>usertest series.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "TestSeries List",
     *    "data": {
     *        "TestSeries_list": [
     *        {
     *            "id": 1,
     *            "name": "fdgfdg",
     *            "created_at": null,
     *            "flag": 1,
     *            "total_ques_no": 12
     *        }
     *      ]
     *   }
     * }
     *
     * @apiError InputMissing Input missing
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Input Missing.",
     *       "data": {}
     *   }
     *
     */
    public function testSeriesList(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("Invalid User ID");
        }
        $dataArray = [];
        $dataArray1 = [];

        $inviteArray = [];
        $inviteArray1 = [];
        $result = TestSeries::where("user_id", $request->user_id)->select('id', 'name', 'total_question', 'created_at')->get();
        foreach ($result as $k => $test) {
            $dataArray[$k]['id'] = $test->id;
            $dataArray[$k]['name'] = $test->name;
            $dataArray[$k]['created_at'] = $test->created_at;
            $date = Carbon::parse($test->created_at);
            $dataArray[$k]['date'] = $date->format("d-M-Y");
            $dataArray[$k]['flag'] = 1;
            $fav = Bookmark::where('user_id', $request->user_id)->where("test_series_id", $test->id)->first();
            if ($fav) {
                $dataArray[$k]['is_bookmark'] = true;
            } else {
                $dataArray[$k]['is_bookmark'] = false;
            }
            $dataArray[$k]['total_ques_no'] = $test->total_question;
        }
        $result1 = UserTestSeries::where("user_id", $request->user_id)->select('id', 'name', 'created_at')->get();
        foreach ($result1 as $k => $test1) {
            $dataArray1[$k]['id'] = $test1->id;
            $dataArray1[$k]['name'] = $test1->name;
            $dataArray1[$k]['created_at'] = $test1->created_at;
            $date = Carbon::parse($test1->created_at);
            $dataArray1[$k]['date'] = $date->format("d-M-Y");
            $dataArray1[$k]['flag'] = 2;
            $fav = Bookmark::where('user_id', $request->user_id)->where("user_test_series_id", $test1->id)->first();
            if ($fav) {
                $dataArray1[$k]['is_bookmark'] = true;
            } else {
                $dataArray1[$k]['is_bookmark'] = false;
            }
            $result1 = UserTestSeriesQuestionAnswer::where("user_test_series_id", $test1->id)->get();
            $dataArray1[$k]['total_ques_no'] = count($result1);
        }
        $invites = Invite::where("user_id", $request->user_id)->where("test_series_id", '!=', 0)->with('testseries')->get();
        foreach ($invites as $k => $invite) {
            $inviteArray[$k]['id'] = $invite->id;
            $inviteArray[$k]['user_name'] = $user->name;
            $inviteArray[$k]['name'] = $invite->testseries->name;
            $inviteArray[$k]['created_at'] = $invite->created_at;
            $date = Carbon::parse($invite->created_at);
            $inviteArray[$k]['date'] = $date->format("d-M-Y");
            $inviteArray[$k]['flag'] = 1;
            $fav = Bookmark::where('user_id', $request->user_id)->where("test_series_id", $invite->test_series_id)->first();
            if ($fav) {
                $inviteArray[$k]['is_bookmark'] = true;
            } else {
                $inviteArray[$k]['is_bookmark'] = false;
            }
        }
        $invites1 = Invite::where("user_id", $request->user_id)->where("user_test_series_id", '!=', 0)->with('usertestseries')->get();
        foreach ($invites1 as $k => $invite1) {
            $inviteArray1[$k]['id'] = $invite1->id;
            $inviteArray1[$k]['user_name'] = $user->name;
            $inviteArray1[$k]['name'] = $invite1->usertestseries->name;
            $inviteArray1[$k]['created_at'] = $invite1->created_at;
            $date = Carbon::parse($invite1->created_at);
            $inviteArray1[$k]['date'] = $date->format("d-M-Y");
            $inviteArray1[$k]['flag'] = 2;
            $fav = Bookmark::where('user_id', $request->user_id)->where("user_test_series_id", $invite1->user_test_series_id)->first();
            if ($fav) {
                $inviteArray1[$k]['is_bookmark'] = true;
            } else {
                $inviteArray1[$k]['is_bookmark'] = false;
            }
        }
        $res = array_merge($dataArray, $dataArray1);
        $res1 = array_merge($inviteArray, $inviteArray1);
        $data['TestSeries_list'] = $res;
        $data['Invite_list'] = $res1;
        return $this->successResponse("TestSeries List", $data);
    }

    /**
     * @api {get} /api/search search
     * @apiHeader {String} Accept application/json.
     * @apiName GetSearch
     * @apiGroup Search
     *
     * @apiParam {String} name Name*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Search Results.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Search Results",
     *    "data": {
     *        "search_list": [
     *        {
     *            "id": 1,
     *            "name": "fdgfdg",
     *            "created_at": null,
     *            "flag": 1,
     *            "total_ques_no": 12
     *        }
     *      ]
     *   }
     * }
     *
     * @apiError InputMissing Input missing
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Input Missing.",
     *       "data": {}
     *   }
     *
     */
    public function search(Request $request) {
        if (!$request->name) {
            return $this->errorResponse("Input Missing.");
        }

        $searchKeyword = $request->name;
        $dataArray = [];
        $dataArray1 = [];
        $result = TestSeries::where("name", "LIKE", "%$searchKeyword%")->select('id', 'name', 'total_question', 'created_at')->get();
        foreach ($result as $k => $test) {
            $dataArray[$k]['id'] = $test->id;
            $dataArray[$k]['name'] = $test->name;
            $dataArray[$k]['created_at'] = $test->created_at;
            $date = Carbon::parse($test->created_at);
                $dataArray[$k]['date'] = $date->format("d-M-Y");
            $dataArray[$k]['flag'] = 1;
            $fav = Bookmark::where('user_id', $request->user_id)->where("test_series_id", $test->id)->first();
            if ($fav) {
                $dataArray[$k]['is_bookmark'] = true;
            } else {
                $dataArray[$k]['is_bookmark'] = false;
            }
            $dataArray[$k]['total_ques_no'] = $test->total_question;
        }
        $result1 = UserTestSeries::where("name", "LIKE", "%$searchKeyword%")->select('id', 'name', 'created_at')->get();
        foreach ($result1 as $k => $test1) {
            $dataArray1[$k]['id'] = $test1->id;
            $dataArray1[$k]['name'] = $test1->name;
            $dataArray1[$k]['created_at'] = $test1->created_at;
            $date = Carbon::parse($test1->created_at);
                $dataArray1[$k]['test_series']['date'] = $date->format("d-M-Y");
            $dataArray1[$k]['flag'] = 2;
            $fav = Bookmark::where('user_id', $request->user_id)->where("user_test_series_id", $test->id)->first();
            if ($fav) {
                $dataArray1[$k]['is_bookmark'] = true;
            } else {
                $dataArray1[$k]['is_bookmark'] = false;
            }
            $dataArray1[$k]['total_ques_no'] = NULL;
        }
        $res = array_merge($dataArray, $dataArray1);
        $data['search_list'] = $res;
        return $this->successResponse("Search Results.", $data);
    }

    /**
     * @api {post} /api/publish-test-series Publish Test Series
     * @apiHeader {String} Accept application/json.
     * @apiName PostPublishTestSeries
     * @apiGroup TestSeries
     *
     * @apiParam {String} test_series_id Test Series ID*.
     * @apiParam {String} user_id User ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message 1=>testseries, 2=>usertest series.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "status": true,
     *    "status_code": 200,
     *    "message": "Publish Successfully",
     *    "data": {}
     * }
     *
     * @apiError userIDMissing The user id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User id missing.",
     *     "data": {}
     *  }
     *
     * @apiError testSeriesidMissing The Test series id missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Test Series Id missing",
     *     "data": {}
     *  }
     *
     * @apiError TestSeriesNotFound Test Series Not Found.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Test Series not found.",
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
     */
    public function publishTestSeries(Request $request) {
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series ID Missing.");
        }
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("Invalid User ID");
        }
        $series = TestSeries::find($request->test_series_id);
        if (!$series) {
            return $this->errorResponse("Invalid Test Series ID");
        }
        $questions = Question::where("test_series_id", $request->test_series_id)->get();
        foreach ($questions as $k => $question) {
            Question::where('id', $question->id)->where('test_series_id', $question->test_series_id)->update(['is_approve' => 1]);
        }
        return $this->successResponse("Publish Successfully", (object) []);
    }

    /**
     * @api {get} /api/test-series Test Series
     * @apiHeader {String} Accept application/json.
     * @apiName GetTestSeries
     * @apiGroup TestSeries
     *
     * @apiParam {String} test_series_id Test Series ID*.
     * @apiParam {String} flag Flag*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message test series.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Test Series.",
     *       "data": {
     *           "test_series": {
     *               "id": 3,
     *               "name": "SSC",
     *               "total_question": 1,
     *               "lang": "English",
     *               "question_time": 45,
     *               "questions": [
     *                   {
     *                       "id": 1,
     *                       "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *                       "ques_image": "http://127.0.0.1:8000/storage/ques_image/ ",
     *                       "ques_time": 20,
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
    public function testSeries(Request $request) {
        if (!$request->test_series_id) {
            return $this->errorResponse("Test series ID missing.");
        }
        if (!in_array($request->flag, [1, 2])) {
            return $this->errorResponse("Select valid flag type");
        }
        if ($request->flag == 1) {
            $testSeries = TestSeries::find($request->test_series_id);
            if ($testSeries) {
                $searchHistory = SearchHistory::where(["test_series_id" => $request->test_series_id, "flag" => $request->flag])->first();
                if ($searchHistory) {
                    $searchHistory->search_count = $searchHistory->search_count + 1;
                    $searchHistory->save();
                } else {
                    $searchHistory = new SearchHistory();
                    $searchHistory->test_series_id = $request->test_series_id;
                    $searchHistory->search_count = 1;
                    $searchHistory->flag = 1;
                    $searchHistory->save();
                }
                $seriesQuestions = Question::where("test_series_id", $testSeries->id)->get();

                $dataArray = [];
                $dataArray['test_series']['id'] = $testSeries->id;
                $dataArray['test_series']['name'] = $testSeries->name;
                $date = Carbon::parse($testSeries->created_at);
                $dataArray['test_series']['date'] = $date->format("d-M-Y");
                $dataArray['test_series']['total_question'] = $testSeries->total_question;
                if ($request->user_id) {
                $fav = Bookmark::where('user_id', $request->user_id)->where('test_series_id', $testseries->id)->first();
                if ($fav) {
                    $dataArray['test_series']['is_bookmark'] = true;
                } else {
                    $dataArray['test_series']['is_bookmark'] = false;
                }}else{
                    $dataArray['test_series']['is_bookmark'] = false;
                }
                $dataArray['test_series']['lang'] = $testSeries->lang == 1 ? "English" : "Hindi";
                $totalTime = 0;
                if ($seriesQuestions) {
                    foreach ($seriesQuestions as $k => $seriesQuestion) {
                        $answers = Answer::where("question_id", $seriesQuestion->id)->get();
                        $dataArray['test_series']['questions'][$k]['id'] = $seriesQuestion->id;
                        $dataArray['test_series']['questions'][$k]['description'] = $seriesQuestion->description;
                        $dataArray['test_series']['questions'][$k]['ques_image'] = $seriesQuestion->ques_image;
                        $dataArray['test_series']['questions'][$k]['ques_time'] = $seriesQuestion->ques_time;
                        $dataArray['test_series']['questions'][$k]['answers'] = $answers;
                        $totalTime += $seriesQuestion->ques_time;
                    }
                } else {
                    $dataArray['test_series']['questions'] = [];
                }
                $dataArray['test_series']['question_time'] = $totalTime;

                return $this->successResponse("Test Series.", $dataArray);
            } else {
                return $this->errorResponse("Invalid Test Series ID.");
            }
        }
        if ($request->flag == 2) {
            $testSeries = UserTestSeries::find($request->test_series_id);
            if ($testSeries) {
                $searchHistory = SearchHistory::where(["test_series_id" => $request->test_series_id, "flag" => $request->flag])->first();
                if ($searchHistory) {
                    $searchHistory->search_count = $searchHistory->search_count + 1;
                    $searchHistory->save();
                } else {
                    $searchHistory = new SearchHistory();
                    $searchHistory->test_series_id = $request->test_series_id;
                    $searchHistory->search_count = 1;
                    $searchHistory->flag = 2;
                    $searchHistory->save();
                }
                $result1 = UserTestSeriesQuestionAnswer::where("user_test_series_id", $testSeries->id)->get();


                $dataArray = [];
                $dataArray['test_series']['id'] = $testSeries->id;
                $dataArray['test_series']['name'] = $testSeries->name;
                $date = Carbon::parse($testSeries->created_at);
                $dataArray['test_series']['date'] = $date->format("d-M-Y");
                if ($request->user_id) {
                    $fav = Bookmark::where('user_id', $request->user_id)->where("test_series_id", $testseries->id)->first();
                    if ($fav) {
                        $dataArray['test_series']['is_bookmark'] = true;
                    } else {
                        $dataArray['test_series']['is_bookmark'] = false;
                    }}else{
                        $dataArray['test_series']['is_bookmark'] = false;
                    }
                $dataArray['test_series']['lang'] = $testSeries->lang == 1 ? "English" : "Hindi";
                $totalTime = 0;
                foreach ($result1 as $k => $result) {
                    $seriesQuestion = Question::find($result->question_id);

                        $answers = Answer::where("question_id", $seriesQuestion->id)->get();
                        $dataArray['test_series']['questions'][$k]['id'] = $seriesQuestion->id;
                        $dataArray['test_series']['questions'][$k]['description'] = $seriesQuestion->description;
                        $dataArray['test_series']['questions'][$k]['ques_image'] = $seriesQuestion->ques_image;
                        $dataArray['test_series']['questions'][$k]['ques_time'] = $seriesQuestion->ques_time;
                        $dataArray['test_series']['questions'][$k]['answers'] = $answers;
                        $totalTime += $seriesQuestion->ques_time;
                    }
                } else {
                    $dataArray['test_series']['questions'] = [];
                }
                $dataArray['test_series']['total_question'] = count($result1);
                $dataArray['test_series']['question_time'] = $totalTime;

                return $this->successResponse("Test Series.", $dataArray);
            } else {
                return $this->errorResponse("Invalid Test Series ID.");
            }

    }

    /**
     * @api {get} /api/search-history Search History
     * @apiHeader {String} Accept application/json.
     * @apiName GetSearchHistory
     * @apiGroup TestSeries
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message test series.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Search History",
     *       "data": {
     *           "trend_search": [
     *               {
     *                   "id": 3,
     *                   "name": "SSC"
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "Math"
     *               }
     *           ],
     *           "recent_search": [
     *               {
     *                   "id": 4,
     *                   "name": "Math"
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "SSC"
     *               }
     *           ]
     *       }
     *   }
     *
     */
    public function searchHistory(Request $request) {
        $trendSearchs = SearchHistory::limit(5)->orderBy("search_count", "DESC")->get();
        $recentSearchs = SearchHistory::limit(5)->orderBy("updated_at", "DESC")->get();
        $dataArrayTrending = [];
        if ($trendSearchs) {
            foreach ($trendSearchs as $k => $trendSearch) {
                if ($trendSearch->flag == 1) {
                    $testSeries = TestSeries::find($trendSearch->test_series_id);
                } else {
                    $testSeries = UserTestSeries::find($trendSearch->test_series_id);
                }
                $dataArrayTrending[$k]['id'] = $testSeries->id;
                $dataArrayTrending[$k]['name'] = $testSeries->name;
                $dataArrayTrending[$k]['flag'] = $trendSearch->flag;
            }
        }
        $dataArrayRecent = [];
        if ($recentSearchs) {
            foreach ($recentSearchs as $k => $recentSearch) {
                if ($trendSearch->flag == 1) {
                    $testSeries = TestSeries::find($trendSearch->test_series_id);
                } else {
                    $testSeries = UserTestSeries::find($trendSearch->test_series_id);
                }
                $dataArrayRecent[$k]['id'] = $testSeries->id;
                $dataArrayRecent[$k]['name'] = $testSeries->name;
                $dataArrayRecent[$k]['flag'] = $trendSearch->flag;
            }
        }
        $data['trend_search'] = $dataArrayTrending;
        $data['recent_search'] = $dataArrayRecent;
        return $this->successResponse("Search History", $data);
    }

    /**
     * @api {get} /api/my-test-series My Test Series List
     * @apiHeader {String} Accept application/json.
     * @apiName GetMyTestSeriesList
     * @apiGroup TestSeries
     *
     * @apiParam {String} user_id User ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message TestSeries List.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "TestSeries List",
     *       "data": {
     *           "my_testseries": [
     *               {
     *                   "id": 2,
     *                   "name": "gggggu",
     *                   "created_at": "2020-01-20T11:47:20.000000Z",
     *                   "flag": 1,
     *                   "date": "23-Jan-2020",
     *                   "is_bookmark":TRUE,
     *                   "total_ques_no": 10
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "gggggu",
     *                   "created_at": "2020-01-20T11:47:31.000000Z",
     *                   "flag": 1,
     *                   "date": "23-Jan-2020",
     *                   "is_bookmark":TRUE,
     *                   "total_ques_no": 10
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "rbi assistant computer",
     *                   "created_at": "2020-01-22T09:47:16.000000Z",
     *                   "flag": 1,
     *                   "date": "23-Jan-2020",
     *                   "is_bookmark":TRUE,
     *                   "total_ques_no": 10
     *               }
     *           ]
     *       }
     *   }
     *
     *
     */
    public function myTestseries(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("Invalid User ID");
        }
        $dataArray = [];

        $inviteArray = [];
        $result = TestSeries::where("user_id", $request->user_id)->select('id', 'name', 'total_question', 'created_at')->get();
        foreach ($result as $k => $test) {
            $dataArray[$k]['id'] = $test->id;
            $dataArray[$k]['name'] = $test->name;
            $dataArray[$k]['created_at'] = $test->created_at;
            $date = Carbon::parse($test->created_at);
            $dataArray[$k]['date'] = $date->format("d-M-Y");
            $dataArray[$k]['flag'] = 1;
            $fav = Bookmark::where('user_id', $request->user_id)->where("test_series_id", $test->id)->first();
            if ($fav) {
                $dataArray[$k]['is_bookmark'] = true;
            } else {
                $dataArray[$k]['is_bookmark'] = false;
            }
            $dataArray[$k]['total_ques_no'] = $test->total_question;
        }
        $data['my_testseries'] = $dataArray;
        return $this->successResponse("TestSeries List", $data);
    }


        /**
     * @api {post} /api/delete-test-series Delete Test Series
     * @apiHeader {String} Accept application/json.
     * @apiName PostDeleteTestSeries
     * @apiGroup TestSeries
     *
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} test_series_id Test Series ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Delete TestSeries List.
     * @apiSuccess {JSON} data response.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "test_series Removed.",
     *       "data": {}
     *   }
     *
     *
     */
    public function deleteTestseries(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("Invalid User ID");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series ID Missing.");
        }
        $testseries = UserTestSeries::find($request->test_series_id);
        if (!$testseries) {
            return $this->errorResponse("Invalid Test Series ID");
        }else{
            $r = UserTestSeries::where("user_id", $request->user_id)->where("id", $request->test_series_id)->delete();
            return $this->successResponse("test_series Removed.", (object) []);
        }

    }
}
