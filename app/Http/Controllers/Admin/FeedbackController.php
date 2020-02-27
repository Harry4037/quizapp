<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
        return view('admin.feedback.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function feedList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Feedback::query()->with('user');
            if ($searchKeyword) {
                $query->whereHas("user", function ($query) use ($searchKeyword) {
                    $query->where("name", "LIKE", "%$searchKeyword%")
                        ->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
                })->orWhere("description", "LIKE", "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $cms = $query->take($limit)->offset($offset)->latest()->get();

            $cmsArray = [];
            foreach ($cms as $k => $cms) {
                $cmsArray[$k]['mobile_number'] = $cms->user->mobile_number;
                $cmsArray[$k]['name'] = $cms->user->name;
                $cmsArray[$k]['description'] = $cms->description;
                // $cmsArray[$k]['action'] = '<a href="' . route('admin.cms.edit', $cms) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;';
            }

            $data['data'] = $cmsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
