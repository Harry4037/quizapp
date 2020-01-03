<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\Exam;

class ExamController extends Controller {

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
     *       "message": "List of Subjects",
     *       "data": [
     *           {
     *               "id": 1,
     *               "name": "SSC",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *               "subject": [
     *                   {
     *                       "id": 1,
     *                       "exam_id": 1,
     *                       "name": "English",
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 2,
     *                       "exam_id": 1,
     *                       "name": "Maths",
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   }
     *               ]
     *           },
     *           {
     *               "id": 2,
     *               "name": "RBI",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *               "subject": [
     *                   {
     *                       "id": 3,
     *                       "exam_id": 2,
     *                       "name": "English",
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   },
     *                   {
     *                       "id": 4,
     *                       "exam_id": 2,
     *                       "name": "Maths",
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "deleted_at": null
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     *  
     * 
     */
    public function examList(Request $request) {
        $exams = Exam::with("subject")->get();
        return $this->successResponse("List of Exams", $exams);
    }

}
