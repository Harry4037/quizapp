<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuiz;
use App\Models\UserQuizQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{

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
    public function userRanking(Request $request)
    {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $userAnswers = DB::select(DB::raw('SELECT SUM(correct_answer) as total_correct_answer, user_id
            FROM (SELECT count(is_correct) as correct_answer, user_id FROM `user_answers` WHERE is_correct = 1 GROUP BY user_id
            UNION
            SELECT SUM(is_correct) as correct_answer, user_id FROM `user_test_series_question_answers` WHERE is_correct = 1 GROUP BY user_id)
            as user_correct_ans GROUP BY user_id ORDER BY total_correct_answer DESC'));
        $dataArray = [];
        $dataArray1 = [];
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
        $dataArray1['users_ranking'] = array_slice($dataArray['users_ranking'], 0, 10);
        $dataArray1['user']['id'] = $userDetail ? $userDetail->id : '';
        $dataArray1['user']['name'] = $userDetail ? $userDetail->name : 'User';
        $dataArray1['user']['profile_pic'] = $userDetail ? $userDetail->profile_pic : '';
        $dataArray1['user']['total_correct_answer'] = $myRanking;
        $dataArray1['user']['rank_number'] = $myRankingNo;
        return $this->successResponse("Ranking list", $dataArray1);
    }
    /**
     * @api {get} /api/leadership Leadership
     * @apiHeader {String} Accept application/json.
     * @apiName GetLeadership
     * @apiGroup Rank
     *
     * @apiParam {String} user_id User ID.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Leadership List.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Leadership list",
     *       "data":[
     *              {
     *               "user_id":2,
     *               "name":"Ankit_creator",
     *               "profile_pic":"http:\/\/127.0.0.1:8000\/img\/no-image.jpg",
     *                "points":3
     *               },
     *               {
     *               "user_id":5,
     *               "name":"shantanu",
     *               "profile_pic":"http:\/\/127.0.0.1:8000\/img\/no-image.jpg",
     *               "points":0
     *               },
     *               {
     *               "user_id":7,
     *              "name":"Sonali",
     *               "profile_pic":"http:\/\/127.0.0.1:8000\/storage\/profile_pic\/P4dx2wtCWVdOSL3j34DOZCiu6Kvn9uSy2dKsFpMw.jpeg",
     *               "points":0
     *               },
     *               {
     *               "user_id":9,
     *               "name":"sonali",
     *               "profile_pic":"http:\/\/127.0.0.1:8000\/img\/no-image.jpg",
     *               "points":0
     *           }
     *       ]
     *   }
     *
     */
    public function leadership(Request $request)
    {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user1 = User::where("id", $request->user_id)->first();
        if (!$user1) {
            return $this->errorResponse("User not found.");
        }
        $creatorUser = User::where('user_type_id', 2)->get();
        $dataArray = [];
        $dataArray1 = [];
        $myRankingNo = 0;
        if ($creatorUser) {
            foreach ($creatorUser as $k => $user) {
                $question = Question::where('user_id', $user->id)->where('is_approve', 2)->count();
                $followers = Follow::where('follow_user_id', $user->id)->count();
                $total = $question + $followers;
                $dataArray['users_leadership'][$k]['user_id'] = $user->id;
                $dataArray['users_leadership'][$k]['name'] = $user ? $user->name : 'User';
                $dataArray['users_leadership'][$k]['profile_pic'] = $user ? $user->profile_pic : '';
                $dataArray['users_leadership'][$k]['points'] = $total;
                if ($user->id == $request->user_id) {
                    $dataArray1['user']['id'] = $user ? $user->id : '';
                    $dataArray1['user']['name'] = $user ? $user->name : 'User';
                    $dataArray1['user']['profile_pic'] = $user ? $user->profile_pic : '';
                    $dataArray1['user']['points'] = $total;
                }
            }
        } else {
            $dataArray['users_leadership'] = [];
        }
        usort($dataArray['users_leadership'], function ($a, $b) {
            return $a['points'] <=> $b['points'];
        });
        $dadt = array_reverse($dataArray['users_leadership']);

        $rr['users_leadership'] = array_slice($dadt, 0, 10);
        foreach ($dadt as $y => $xyz) {
            if ($xyz['user_id'] == $request->user_id) {
                $dataArray1['user']['rank_number'] = $y + 1;
            }
        }
        $fdf = array_merge($rr, $dataArray1);
        return $this->successResponse("Leadership list", $fdf);
    }

    /**
     * @api {get} /api/quiz-ranking Quiz Ranking
     * @apiHeader {String} Accept application/json.
     * @apiName Getquizranking
     * @apiGroup Rank
     *
     * @apiParam {String} user_id User ID.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Quiz Ranking  list.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *   "status":true,
     *   "status_code":200,
     *   "message":"Quiz Ranking list",
     *   "data":{
     *          "users_leadership":[
     *          {
     *"user_id":16,
     *"name":"Sonali",
     *"profile_pic":"http:\/\/127.0.0.1:8000\/storage\/profile_pic\/2gaeu9QoWVryb5WavH5mi1NJPRs12To9jKrXU3OA.jpeg",
     *"points":9
     *},
     *{
     *"user_id":24,
     *"name":"11114",
     *"profile_pic":"http:\/\/127.0.0.1:8000\/img\/no-image.jpg",
     *"points":9
     *}
     *],
     *"user":{
     *"id":24,
     *"name":"11114",
     *"profile_pic":"http:\/\/127.0.0.1:8000\/img\/no-image.jpg",
     *"points":9,
     *"rank_number":2
     *}
     *}
     *}
     *
     */

    public function quizRanking(Request $request)
    {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user1 = User::where("id", $request->user_id)->first();
        if (!$user1) {
            return $this->errorResponse("User not found.");
        }
        $datee = date('Y-m-d');
        $quizzz = Quiz::where('start_date_time', 'LIKE', $datee . '%')->first();
        $AllUser = UserQuiz::where('quiz_id', $quizzz->id)->with('user_quiz')->get();
        $dataArray = [];
        $dataArray1 = [];
        $myRankingNo = 0;
        if ($AllUser) {
            foreach ($AllUser as $k => $user) {
                $Details = User::where('id', $user->user_id)->first();
                $points = UserQuizQuestionAnswer::where('user_quiz_id', $user->user_quiz->id)->where('is_correct', 1)->count();
                $dataArray['users_leadership'][$k]['user_id'] = $Details->id;
                $dataArray['users_leadership'][$k]['name'] = $Details ? $Details->name : 'User';
                $dataArray['users_leadership'][$k]['profile_pic'] = $Details ? $Details->profile_pic : '';
                $dataArray['users_leadership'][$k]['points'] = $points;
                if ($Details->id == $request->user_id) {
                    $dataArray1['user']['id'] = $Details ? $Details->id : '';
                    $dataArray1['user']['name'] = $Details ? $Details->name : 'User';
                    $dataArray1['user']['profile_pic'] = $Details ? $Details->profile_pic : '';
                    $dataArray1['user']['points'] = $points;
                }
            }
        } else {
            $dataArray['users_leadership'] = [];
        }
        usort($dataArray['users_leadership'], function ($a, $b) {
            return $a['points'] <=> $b['points'];
        });
        $dadt = array_reverse($dataArray['users_leadership']);

        $rr['users_leadership'] = array_slice($dadt, 0, 10);
        foreach ($dadt as $y => $xyz) {
            if ($xyz['user_id'] == $request->user_id) {
                $dataArray1['user']['rank_number'] = $y + 1;
            }
        }
        $fdf = array_merge($rr, $dataArray1);
        return $this->successResponse("Quiz Ranking  list", $fdf);
    }
}
