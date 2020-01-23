<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\quiz;
use App\Models\Subject;
use App\Models\Exam;

class QuizController extends Controller {

    public function index(Request $request) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
        ];
        return view('admin.quiz.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function quizList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = quiz::query();
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $questions = $query->take($limit)->offset($offset)->latest()->get();

            $questionsArray = [];
            foreach ($questions as $k => $question) {
                $questionsArray[$k]['name'] = $question->name;
                $questionsArray[$k]['start_at'] = date('d-M-Y, h:i A', strtotime($question->start_date_time));
                $questionsArray[$k]['end_at'] = date('d-M-Y, h:i A', strtotime($question->end_date_time));
                $questionsArray[$k]['action'] = '';
//                        '<a href="' . route('admin.question.edit', $question) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
//                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $question->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $questionsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function quizAdd(Request $request) {
        try {
            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];
            if ($request->isMethod("post")) {
//                $validator = Validator::make($request->all(), [
//                            'question_name' => [
//                                'bail',
//                                'required',
//                                Rule::unique('questions', 'description')->where(function ($query) use($request) {
//                                            return $query->where(['description' => $request->question_name])
//                                                            ->whereNull('deleted_at');
//                                        }),
//                            ],
//                ]);
//                if ($validator->fails()) {
//                    return redirect()->route('admin.question.add')->withErrors($validator)->withInput();
//                }
//                $question = new Question();
//
//                $question->description = $request->question_name;
//
//                if ($question->save()) {
//                    return redirect()->route('admin.question.index')->with('status', 'Question has been updated successfully.');
//                } else {
//                    return redirect()->route('admin.question.index')->with('error', 'Something went be wrong.');
//                }
            }
            $subjects = Subject::get();
            $exams = Exam::get();
            return view('admin.quiz.add', [
                'css' => $css,
                'js' => $js,
                'subjects' => $subjects,
                'exams' => $exams
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.quiz.index')->with('error', $ex->getMessage());
        }
    }

    public function questionDelete(Request $request) {
        try {
            $question = Question::find($request->id);
            if ($question) {
                $question->delete();
                return ['status' => true, "message" => "Question deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function questionEdit(Request $request, Question $question) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'question_name' => [
                                'bail',
                                'required',
                                Rule::unique('questions', 'description')->ignore($question->id)->where(function ($query) use($request) {
                                            return $query->where(['description' => $request->question_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.question.edit', $question->id)->withErrors($validator)->withInput();
                }
                $question->description = $request->question_name;

                if ($question->save()) {
                    return redirect()->route('admin.question.index')->with('status', 'Question has been updated successfully.');
                } else {
                    return redirect()->route('admin.question.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.question.edit', [
                'question' => $question
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.question.index')->with('error', $ex->getMessage());
        }
    }

}
