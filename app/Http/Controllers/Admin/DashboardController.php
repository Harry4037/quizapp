<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function index(Request $request) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
        ];

        $userAnswers = DB::select(DB::raw('SELECT SUM(correct_answer) as total_correct_answer, user_id
            FROM (SELECT count(is_correct) as correct_answer, user_id FROM `user_answers` WHERE is_correct = 1 GROUP BY user_id
            UNION
            SELECT SUM(is_correct) as correct_answer, user_id FROM `user_test_series_question_answers` WHERE is_correct = 1 GROUP BY user_id)
            as user_correct_ans GROUP BY user_id ORDER BY total_correct_answer DESC'));
        $rankingArray = [];
        if ($userAnswers) {
            foreach ($userAnswers as $k => $userAnswer) {
                $user = User::find($userAnswer->user_id);
                $rankingArray[$k]['user_id'] = $userAnswer->user_id;
                $rankingArray[$k]['name'] = $user ? $user->name : 'User';
                $rankingArray[$k]['profile_pic'] = $user ? $user->profile_pic : '';
                $rankingArray[$k]['total_correct_answer'] = $userAnswer->total_correct_answer;
            }
        } else {
            $rankingArray = [];
        }

        $totalQuestionCount = Question::count();
        $usersCount = User::where('user_type_id', 3)->count();
        $creatorCount = User::where('user_type_id', 2)->count();
        return view('admin.dashboard.index', [
            'usersCount' => $usersCount,
            'creatorCount' => $creatorCount,
            'totalQuestionCount' => $totalQuestionCount,
            'rankingArray' => $rankingArray,
            'js' => $js,
            'css' => $css,
        ]);
    }

}
