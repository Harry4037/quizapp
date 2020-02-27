<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class SubjectController extends Controller
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
        return view('admin.subject.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function subjectList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Subject::query();
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $subjects = $query->take($limit)->offset($offset)->latest()->get();

            $subjectsArray = [];
            foreach ($subjects as $k => $subject) {
                $subjectsArray[$k]['name'] = $subject->name;
                $subjectsArray[$k]['action'] = '<a href="' . route('admin.subject.edit', $subject) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $subject->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $subjectsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function subjectDelete(Request $request)
    {
        try {
            $subject = Subject::find($request->id);
            if ($subject) {
                $subject->delete();
                return ['status' => true, "message" => "Subject deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function subjectEdit(Request $request, Subject $subject)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'subject_name' => [
                        'bail',
                        'required',
                        Rule::unique('subjects', 'name')->ignore($subject->id)->where(function ($query) use ($request) {
                            return $query->where(['name' => $request->subject_name])
                                ->whereNull('deleted_at');
                        }),
                    ],

                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.subject.edit', $subject->id)->withErrors($validator)->withInput();
                }
                $subject->name = $request->subject_name;

                if ($subject->save()) {
                    return redirect()->route('admin.subject.index')->with('status', 'Subject has been updated successfully.');
                } else {
                    return redirect()->route('admin.subject.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.subject.edit', [
                'subject' => $subject,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.subject.index')->with('error', $ex->getMessage());
        }
    }

    public function subjectAdd(Request $request)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'subject_name' => [
                        'bail',
                        'required',
                        Rule::unique('subjects', 'name')->where(function ($query) use ($request) {
                            return $query->where(['name' => $request->subject_name])
                                ->whereNull('deleted_at');
                        }),
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.subject.add')->withErrors($validator)->withInput();
                }
                $subject = new Subject();

                $subject->name = $request->subject_name;

                if ($subject->save()) {
                    return redirect()->route('admin.subject.index')->with('status', 'Subject has been updated successfully.');
                } else {
                    return redirect()->route('admin.subject.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.subject.add');
        } catch (\Exception $ex) {
            return redirect()->route('admin.subject.index')->with('error', $ex->getMessage());
        }
    }

}
