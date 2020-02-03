<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserTestSeriesQuestionAnswer;

class RankingController extends Controller {

    /**
     * @api {get} /api/user-ranking  User Raking
     * @apiHeader {String} Accept application/json.
     * @apiName GetUserRanking
     * @apiGroup Rank
     *
     *
     * @apiParam {String} user_id User ID.
     * 
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Rank List.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Ranking list",
     *       "data": {
     *           "users_ranking": [
     *               {
     *                   "user_id": 2,
     *                   "name": "Ankit_creator",
     *                   "profile_pic": "http://127.0.0.1:8000/img/no-image.jpg",
     *                   "total_correct_answer": "6"
     *               },
     *               {
     *                   "user_id": 3,
     *                   "name": "Ankit_user",
     *                   "profile_pic": "http://127.0.0.1:8000/img/no-image.jpg",
     *                   "total_correct_answer": "4"
     *               }
     *           ],
     *           "user": {
     *               "id": 3,
     *               "name": "Ankit_user",
     *               "profile_pic": "http://127.0.0.1:8000/img/no-image.jpg",
     *               "total_correct_answer": "4",
     *               "rank_number": 2
     *           }
     *       }
     *   }
     *
     */
    public function userRanking(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $userAnswers = DB::select(DB::raw('SELECT SUM(correct_answer) as total_correct_answer, user_id 
            FROM (SELECT count(is_correct) as correct_answer, user_id FROM `user_answers` WHERE is_correct = 1 GROUP BY user_id
            UNION
            SELECT SUM(is_correct) as correct_answer, user_id FROM `user_test_series_question_answers` WHERE is_correct = 1 GROUP BY user_id) 
            as user_correct_ans GROUP BY user_id ORDER BY total_correct_answer DESC'));
        $dataArray = [];
        $myRanking = 0;
        $myRankingNo = 0;
        if ($userAnswers) {
            foreach ($userAnswers as $k => $userAnswer) {
                $user = User::find($userAnswer->user_id);
                $dataArray['users_ranking'][$k]['user_id'] = $userAnswer->user_id;
                $dataArray['users_ranking'][$k]['name'] = $user ? $user->name : 'User';
                $dataArray['users_ranking'][$k]['profile_pic'] = $user ? $user->profile_pic : '';
                $dataArray['users_ranking'][$k]['total_correct_answer'] = $userAnswer->total_correct_answer;
                if ($userAnswer->user_id == $request->user_id) {
                    $myRanking = $userAnswer->total_correct_answer;
                    $myRankingNo = $k + 1;
                }
            }
        } else {
            $dataArray['users_ranking'] = [];
        }

        $userDetail = User::find($request->user_id);
        $dataArray['user']['id'] = $userDetail ? $userDetail->id : '';
        $dataArray['user']['name'] = $userDetail ? $userDetail->name : 'User';
        $dataArray['user']['profile_pic'] = $userDetail ? $userDetail->profile_pic : '';
        $dataArray['user']['total_correct_answer'] = $myRanking;
        $dataArray['user']['rank_number'] = $myRankingNo;
        return $this->successResponse("Ranking list", $dataArray);
    }

}
