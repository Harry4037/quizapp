<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class LeadershipController extends Controller
{

    public function index(Request $request)
    {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.leadership.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function leadershipList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = User::query();
            $query->where('user_type_id', 2)->withTrashed();
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = 10;
            $data['recordsFiltered'] = 10;
            $creatorUser = $query->take(10000)->offset($offset)->latest()->get();
            $dataArray = [];
            foreach ($creatorUser as $k => $user) {
                $question = Question::where('user_id', $user->id)->where('is_approve', 2)->count();
                $followers = Follow::where('follow_user_id', $user->id)->count();
                $total = $question + $followers;
                $dataArray['users_leadership'][$k]['name'] = $user->name;
                $dataArray['users_leadership'][$k]['mob'] = $user->mobile_number;
                $dataArray['users_leadership'][$k]['image'] = '<img class="img-bordered" height="60" width="100" src=' . $user->profile_pic . '>';
                $dataArray['users_leadership'][$k]['points'] = $total;
            }
            usort($dataArray['users_leadership'], function ($a, $b) {
                return $a['points'] <=> $b['points'];
            });
            $dadt = array_reverse($dataArray['users_leadership']);
            $rr = array_slice($dadt, 0, 10);
            $data['data'] = $rr;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
