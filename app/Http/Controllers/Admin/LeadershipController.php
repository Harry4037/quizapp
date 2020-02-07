<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\Question;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;

class LeadershipController extends Controller {

    public function index(Request $request) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
        ];
        return view('admin.leadership.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function leadershipList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = User::query();
            $query->where('user_type_id',2);
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $creatorUser = $query->take($limit)->offset($offset)->get();

            $dataArray = [];
            $dataArray1 = [];
            foreach ($creatorUser as $k => $user) {
                $question = Question::where('user_id', $user->id)->where('is_approve', 2)->count();
                $followers = Follow::where('follow_user_id',$user->id)->count();
                $total = $question + $followers;
                $dataArray['leadership'][$k]['name'] =  $user->name;
                $dataArray['leadership'][$k]['image'] = '<img class="img-bordered" height="60" width="100" src=' . $user->profile_pic . '>';
                $dataArray['leadership'][$k]['points'] = $total;
            }
            $dataArray1 = collect($dataArray['leadership'])->SortByDesc('points');
            $data['data'] = $dataArray1;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
