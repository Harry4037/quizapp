<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;

class DashboardController extends Controller {

    public function index(Request $request) {
        $usersCount = User::where('user_type_id', 3)->count();
        $staffCount = User::where('user_type_id', 2)->count();
        return view('admin.dashboard.index', [
            'usersCount' => $usersCount,
            'staffCount' => $staffCount,
        ]);
    }

}
