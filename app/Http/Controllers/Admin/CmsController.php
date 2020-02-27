<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;
use Validator;

class CmsController extends Controller
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
        return view('admin.cms.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function cmsList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Cms::query();
            if ($searchKeyword) {
                $query->where("page_name", 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $cms = $query->take($limit)->offset($offset)->latest()->get();

            $cmsArray = [];
            foreach ($cms as $k => $cms) {
                $cmsArray[$k]['page_name'] = $cms->page_name;
                $cmsArray[$k]['description'] = $cms->description;
                $cmsArray[$k]['mobile'] = $cms->mobile;
                $cmsArray[$k]['email'] = $cms->email;
                $cmsArray[$k]['action'] = '<a href="' . route('admin.cms.edit', $cms) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;';
            }

            $data['data'] = $cmsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function cmsEdit(Request $request, Cms $cms)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'description' => [
                        'bail',
                        'required',
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.cms.edit', $cms->id)->withErrors($validator)->withInput();
                }

                $cms->description = $request->description;
                $cms->title = $request->mobile;
                // $cms->email = $request->email;

                if ($cms->save()) {
                    return redirect()->route('admin.cms.index')->with('status', 'CMS has been updated successfully.');
                } else {
                    return redirect()->route('admin.cms.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.cms.edit', [
                'cms' => $cms,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.cms.index')->with('error', $ex->getMessage());
        }
    }

}
