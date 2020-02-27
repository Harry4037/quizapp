<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    /**
     * @api {get} /api/exam-list  Exam List
     * @apiHeader {String} Accept application/json.
     * @apiName GetExamList
     * @apiGroup Exam
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message List of Exams.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "List of Exams",
     *       "data": [
     *           {
     *               "id": 1,
     *               "name": "SSC",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           },
     *           {
     *               "id": 2,
     *               "name": "RBI",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           }
     *       ]
     *   }
     *
     *
     */
    public function examList(Request $request)
    {
        $exams = Exam::get();
        return $this->successResponse("List of Exams", $exams);
    }

}
