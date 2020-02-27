<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    /**
     * @api {get} /api/subject-list  Subject List
     * @apiHeader {String} Accept application/json.
     * @apiName GetSubjectList
     * @apiGroup Subject
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message List of Subjects.
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
     *               "name": "English",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           },
     *           {
     *               "id": 2,
     *               "name": "Hindi",
     *               "created_at": null,
     *               "updated_at": null,
     *               "deleted_at": null,
     *           }
     *       ]
     *   }
     *
     *
     */
    public function subjectList(Request $request)
    {
        $subjects = Subject::get();
        return $this->successResponse("List of Subjects", $subjects);
    }

}
