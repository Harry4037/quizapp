<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;

class DashboardController extends Controller {

    public function index(Request $request) {
        $totalQuestionCount = Question::count();
        $usersCount = User::where('user_type_id', 2)->count();
        $creatorCount = User::where('user_type_id', 3)->count();
        return view('admin.dashboard.index', [
            'usersCount' => $usersCount,
            'creatorCount' => $creatorCount,
            'totalQuestionCount' => $totalQuestionCount,
        ]);
    }

}
