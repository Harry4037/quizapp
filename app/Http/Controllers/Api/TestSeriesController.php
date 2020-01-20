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
use App\Models\UserTestSeries;

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
            return $this->errorResponse("Test Series created succesfully.");
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
        $result = TestSeries::where("user_id", $request->user_id)->select('id','name','total_question','created_at')->get();
         foreach ($result as $k => $test) {
            $dataArray[$k]['id'] = $test->id;
            $dataArray[$k]['name'] = $test->name;
            $dataArray[$k]['created_at'] = $test->created_at;
            $dataArray[$k]['flag'] = 1;
            $dataArray[$k]['total_ques_no'] = $test->total_question;
        }
        $result1 = UserTestSeries::where("user_id", $request->user_id)->select('id','name','created_at')->get();
        foreach ($result1 as $k => $test1) {
            $dataArray1[$k]['id'] = $test1->id;
            $dataArray1[$k]['name'] = $test1->name;
            $dataArray1[$k]['created_at'] = $test1->created_at;
            $dataArray1[$k]['flag'] = 2;
            $dataArray1[$k]['total_ques_no'] = NULL;
        }
        $res = array_merge($dataArray, $dataArray1);
        $data['TestSeries_list']=$res;
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
     * @apiSuccess {String} message 1=>testseries, 2=>usertest series.
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
        }else{
            $searchKeyword = $request->name;
            $dataArray = [];
            $dataArray1 = [];
            $result = TestSeries::where("name", "LIKE", "%$searchKeyword%")->select('id','name','total_question','created_at')->get();
             foreach ($result as $k => $test) {
                $dataArray[$k]['id'] = $test->id;
                $dataArray[$k]['name'] = $test->name;
                $dataArray[$k]['created_at'] = $test->created_at;
                $dataArray[$k]['flag'] = 1;
                $dataArray[$k]['total_ques_no'] = $test->total_question;
            }
            $result1 = UserTestSeries::where("name", "LIKE", "%$searchKeyword%")->select('id','name','created_at')->get();
            foreach ($result1 as $k => $test1) {
                $dataArray1[$k]['id'] = $test1->id;
                $dataArray1[$k]['name'] = $test1->name;
                $dataArray1[$k]['created_at'] = $test1->created_at;
                $dataArray1[$k]['flag'] = 2;
                $dataArray1[$k]['total_ques_no'] = NULL;
            }
            $res = array_merge($dataArray, $dataArray1);
            $data['search_list']=$res;
            return $this->successResponse("Search Results", $data);
        }

    }
}
