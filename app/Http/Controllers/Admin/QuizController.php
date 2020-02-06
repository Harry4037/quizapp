<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;

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

            $query = Quiz::query();
            if ($searchKeyword) {
                $query->where('name', 'LIKE', "%$searchKeyword%");
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $questions = $query->take($limit)->offset($offset)->latest()->get();

            $questionsArray = [];
            foreach ($questions as $k => $question) {
                $questionsArray[$k]['name'] = $question->name;
                $questionsArray[$k]['total_question'] = $question->total_questions;
                $questionsArray[$k]['start_at'] = date('d-M-Y, h:i A', strtotime($question->start_date_time));
                $questionsArray[$k]['end_at'] = date('d-M-Y, h:i A', strtotime($question->end_date_time));
                $questionsArray[$k]['action'] = '<a href="' . route('admin.quiz.edit', $question) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                        . '<a href="' . route('admin.quiz.question-list', $question) . '" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> View Questions </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $question->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $questionsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function quizAdd(Request $request) {
        try {

            if ($request->isMethod("post")) {
//
//                $validator = Validator::make($request->all(), [
//                            'quiz_name' => [
//                                'required',
//                                Rule::unique('questions', 'description')->where(function ($query) use($request) {
//                                            return $query->where(['description' => $request->description])
//                                                            ->whereNull('deleted_at');
//                                        }),
//                            ],
//                ]);
//                if ($validator->fails()) {
//                    return redirect()->route('admin.question.add')->withErrors($validator)->withInput();
//                }

                $quiz = new Quiz();
                $quiz->user_id = auth()->user()->id;
                $quiz->name = $request->quiz_name;
                $quiz->total_questions = $request->total_question;
                $quiz->start_date_time = date('Y-m-d h:i:s', strtotime($request->start_date_time));
                $quiz->end_date_time = date('Y-m-d h:i:s', strtotime($request->end_date_time));
                $quiz->lang = $request->lang;

                if ($quiz->save()) {
                    foreach ($request->description as $k => $ques) {
                        $question = new Question();
                        if ($request->hasFile('ques_image.' . $k)) {
                            $ques_image = $request->file("ques_image." . $k);
                            $quesImage = Storage::disk('public')->put('ques_image', $ques_image);
                            $ques_file_name = basename($quesImage);
                            $question->ques_image = $ques_file_name;
                        } else {
                            $question->ques_image = '';
                        }

                        $question->user_id = 1;
                        $question->exam_id = 0;
                        $question->subject_id = 0;
                        $question->test_series_id = 0;
                        $question->quiz_id = $quiz->id;
                        $question->is_approve = 2;
                        $question->description = $ques;

                        $question->ques_time = 0;

                        if ($question->save()) {
                            $answer = new Answer();
                            $answer->question_id = $question->id;
                            $answer->description = $request->ans1[$k];
                            if ($request->correct_answer[$k] == "opt1") {
                                $answer->is_answer = 1;
                            } else {
                                $answer->is_answer = 0;
                            }
                            $answer->save();

                            $answer = new Answer();
                            $answer->question_id = $question->id;
                            $answer->description = $request->ans2[$k];
                            if ($request->correct_answer[$k] == "opt2") {
                                $answer->is_answer = 1;
                            } else {
                                $answer->is_answer = 0;
                            }
                            $answer->save();

                            $answer = new Answer();
                            $answer->question_id = $question->id;
                            $answer->description = $request->ans3[$k];
                            if ($request->correct_answer[$k] == "opt3") {
                                $answer->is_answer = 1;
                            } else {
                                $answer->is_answer = 0;
                            }
                            $answer->save();

                            $answer = new Answer();
                            $answer->question_id = $question->id;
                            $answer->description = $request->ans4[$k];
                            if ($request->correct_answer[$k] == "opt4") {
                                $answer->is_answer = 1;
                            } else {
                                $answer->is_answer = 0;
                            }
                            $answer->save();
                        }
                    }
                    return redirect()->route('admin.quiz.index')->with('status', 'Daily Quiz added successfully.');
                } else {
                    return redirect()->route('admin.quiz.index')->with('error', 'Something went be wrong.');
                }
            }

            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];

            return view('admin.quiz.add', [
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.quiz.index')->with('error', $ex->getMessage());
        }
    }

    public function quizDelete(Request $request) {
        try {
            $quiz = Quiz::find($request->id);
            $questions = Question::where("quiz_id", $quiz->id)->get();
            if ($quiz) {
                $quiz->delete();
                if ($questions) {
                    Question::where("quiz_id", $quiz->id)->delete();
                    foreach ($questions as $que) {
                        Answer::where('question_id', $que->id)->delete();
                    }
                }
                return ['status' => true, "message" => "Quiz deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function quizEdit(Request $request, Quiz $quiz) {
        try {
            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];
            if ($request->isMethod("post")) {
                $quiz->user_id = auth()->user()->id;
                $quiz->name = $request->quiz_name;
                $quiz->start_date_time = date('Y-m-d h:i:s', strtotime($request->start_date_time));
                $quiz->end_date_time = date('Y-m-d h:i:s', strtotime($request->end_date_time));
                $quiz->lang = $request->lang;
                if ($quiz->save()) {
                    return redirect()->route('admin.quiz.index')->with('status', 'Quiz has been updated successfully.');
                } else {
                    return redirect()->route('admin.quiz.index')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.quiz.edit', [
                'quiz' => $quiz,
                'css' => $css,
                'js' => $js
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.quiz.index')->with('error', $ex->getMessage());
        }
    }

    public function quizQuestionList(Request $request, Quiz $quiz) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'
        ];

        $questions = Question::where("quiz_id", $quiz->id)->get();
        return view('admin.quiz.question-list', [
            'questions' => $questions,
            'quiz' => $quiz,
            'css' => $css,
            'js' => $js
        ]);
    }

    public function quizQuestionAdd(Request $request, Quiz $quiz) {

        if ($request->isMethod("post")) {

            foreach ($request->description as $k => $ques) {
                $question = new Question();
                if ($request->hasFile('ques_image.' . $k)) {
                    $ques_image = $request->file("ques_image." . $k);
                    $quesImage = Storage::disk('public')->put('ques_image', $ques_image);
                    $ques_file_name = basename($quesImage);
                    $question->ques_image = $ques_file_name;
                } else {
                    $question->ques_image = '';
                }

                $question->user_id = 1;
                $question->exam_id = 0;
                $question->subject_id = 0;
                $question->test_series_id = 0;
                $question->quiz_id = $quiz->id;
                $question->lang = $quiz->lang;
                $question->is_approve = 2;
                $question->description = $ques;

                $question->ques_time = 0;

                if ($question->save()) {
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans1[$k];
                    if ($request->correct_answer[$k] == "opt1") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();

                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans2[$k];
                    if ($request->correct_answer[$k] == "opt2") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();

                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans3[$k];
                    if ($request->correct_answer[$k] == "opt3") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();

                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans4[$k];
                    if ($request->correct_answer[$k] == "opt4") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();
                }
            }
            $questionCount = Question::where("quiz_id", $quiz->id)->count();
            $quiz->total_questions = $questionCount;
            $quiz->save();
            return redirect()->route('admin.quiz.index')->with('status', 'Question added successfully.');
        }

        return view('admin.quiz.question-add', [
            'quiz' => $quiz,
        ]);
    }

    public function quizQuestionEdit(Request $request, Question $question) {

        if ($request->isMethod('post')) {
            if ($request->hasFile('ques_image')) {
                $quesImg = Question::selectRaw('ques_image img')->find($question->id);
                Storage::disk('public')->delete('ques_image/' . $quesImg->img);
                $ques_image = $request->file("ques_image");
                $quesImage = Storage::disk('public')->put('ques_image', $ques_image);
                $ques_file_name = basename($quesImage);
                $question->ques_image = $ques_file_name;
            }
            $question->description = $request->description;

            if ($question->save()) {
                if ($request->correct_answer == "opt1") {
                    Answer::where('id', $request->answer1)->update(['description' => $request->ans1, 'is_answer' => 1]);
                    Answer::where('id', $request->answer2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->answer3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->answer4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt2") {
                    Answer::where('id', $request->answer1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->answer2)->update(['description' => $request->ans2, 'is_answer' => 1]);
                    Answer::where('id', $request->answer3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->answer4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt3") {
                    Answer::where('id', $request->answer1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->answer2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->answer3)->update(['description' => $request->ans3, 'is_answer' => 1]);
                    Answer::where('id', $request->answer4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt4") {
                    Answer::where('id', $request->answer1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->answer2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->answer3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->answer4)->update(['description' => $request->ans4, 'is_answer' => 1]);
                }
                return redirect()->route('admin.quiz.index')->with('status', 'Question has been updated successfully.');
            }
        }

        $answers = Answer::where('question_id', $question->id)->get();
        return view('admin.quiz.question-edit', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

    public function deleteQuizQuestion(Request $request) {
        try {
            $question = Question::find($request->id);
            if ($question) {
                $question->delete();
                $quiz = Quiz::find($question->quiz_id);
                if ($quiz) {
                    $quiz->total_questions = $quiz->total_questions - 1;
                    $quiz->save();
                }
                return ['status' => true, "message" => "Question deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

}
