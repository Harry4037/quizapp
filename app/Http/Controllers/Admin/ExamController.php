<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Exam;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;

class ExamController extends Controller {

    public function index(Request $request) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
        ];
        return view('admin.exam.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function examList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Exam::query();
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $exams = $query->take($limit)->offset($offset)->latest()->get();

            $examsArray = [];
            foreach ($exams as $k => $exam) {
                $examsArray[$k]['name'] = $exam->name;
                $examsArray[$k]['action'] = '<a href="' . route('admin.exam.edit', $exam) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $exam->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $examsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function examDelete(Request $request) {
        try {
            $exam = Exam::find($request->id);
            if ($exam) {
                $exam->delete();
                return ['status' => true, "message" => "Exam deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function examEdit(Request $request, Exam $exam) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'exam_name' => [
                                'bail',
                                'required',
                                Rule::unique('exams', 'name')->ignore($exam->id)->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->exam_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],

                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.exam.edit', $exam->id)->withErrors($validator)->withInput();
                }
                $exam->name = $request->exam_name;

                if ($exam->save()) {
                    return redirect()->route('admin.exam.index')->with('status', 'Exam has been updated successfully.');
                } else {
                    return redirect()->route('admin.exam.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.exam.edit', [
                'exam' => $exam
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.subjexamect.index')->with('error', $ex->getMessage());
        }
    }

    public function examAdd(Request $request) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'exam_name' => [
                                'bail',
                                'required',
                                Rule::unique('exams', 'name')->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->exam_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                    ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.exam.add')->withErrors($validator)->withInput();
                }
                $exam = new Exam();

                $exam->name = $request->exam_name;

                if ($exam->save()) {
                    return redirect()->route('admin.exam.index')->with('status', 'Exam has been updated successfully.');
                } else {
                    return redirect()->route('admin.exam.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.exam.add');
        } catch (\Exception $ex) {
            return redirect()->route('admin.exam.index')->with('error', $ex->getMessage());
        }
    }

}
