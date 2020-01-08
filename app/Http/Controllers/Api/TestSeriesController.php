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

class TestSeriesController extends Controller {

     /**
     * @api {get} /api/test-series  Test Series
     * @apiHeader {String} Accept application/json.
     * @apiName GetTestSeries
     * @apiGroup TestSeries
     *
     * @apiParam {String} user_id User Id .
     * @apiParam {String} subject_id Subject Id.
     * @apiParam {String} series_name Test Series Name.
     * @apiParam {String} total_question Total no. of questions*.
     * @apiParam {String} lang Language(English=>1,Hindi=>2)*.
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
        if (!$request->user_id) {
            return $this->errorResponse("user id missing");
        }
        if (!$request->series_name) {
            return $this->errorResponse("Test Series Name missing");
        }
        if (!$request->total_question) {
            return $this->errorResponse("Total questin missing");
        }
        if (!$request->lang) {
            return $this->errorResponse("lang missing");
        }
        if (!$request->subject_id) {
            return $this->errorResponse("subject ID missing");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User not found.");
        }
        $subject = Subject::find($request->subject_id);
        if (!$subject) {
            return $this->errorResponse("Subject not found.");
        }
        $series = new TestSeries();
        $series->user_id = $request->user_id;
        $series->subject_id = $request->subject_id;
        $series->name = $request->series_name;
        $series->total_question = $request->total_question;
        $series->lang = $request->lang;

        if ($series->save()) {
            $data['id'] = $series->id;
            $data['subject_id'] = $request->subject_id;
            $data['subject_name'] = $subject->name;
            return $this->successResponse("Test Series Created successfully", $data);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }
     /**
     * @api {get} /api/series-question  Series Question
     * @apiHeader {String} Accept application/json.
     * @apiName GetSeriesQuestion
     * @apiGroup TestSeries
     *
     * @apiParam {String} user_id User Id .
     * @apiParam {String} subject_id Subject Id.
     * @apiParam {String} series_name Test Series Name.
     * @apiParam {String} ques_no Total no. of questions*.
     * @apiParam {String} lang Language(English=>1,Hindi=>2)*.
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
    public function createTestSeriesQues(Request $request) {
        if (!$request->description) {
            return $this->errorResponse("description missing");
        }
        if (!$request->ques_time) {
            return $this->errorResponse("Question Time missing");
        }
        if (!$request->test_series_id) {
            return $this->errorResponse("Test Series Id missing");
        }
        if (!$request->subject_id) {
            return $this->errorResponse("subject ID missing");
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
        }else{
            $question->ques_image = NULL;
        }
       $question->exam_id = 0;
       $question->description = $request->description;
       $question->ques_time = $request->ques_time;
       $question->subject_id = $request->subject_id;
       $question->test_series_id = $request->test_series_id;
       if ($question->save()) {
        return $this->successResponse("Question Added successfully", (object) []);
    } else {
        return $this->errorResponse("Something went wrong.");
    }

    }

}
