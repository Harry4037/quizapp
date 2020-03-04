<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Invite;
use App\Models\Question;
use App\Models\QuestionExam;
use App\Models\Subject;
use App\Models\TestSeries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Validation\Rule;

class TestSeriesController extends Controller {

    public function index(Request $request) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];
        return view('admin.test-series.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function testSeriesList(Request $request) {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = TestSeries::query()->with('subject');
            $query->whereNotNull("is_approve");
            if ($searchKeyword) {
                $query->whereHas("subject", function ($query) use ($searchKeyword) {
                    $query->where("name", "LIKE", "%$searchKeyword%");
                });
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $testseriess = $query->take($limit)->offset($offset)->latest()->get();

            $testseriesArray = [];
            foreach ($testseriess as $k => $testseries) {
                $times = Question::where('test_series_id', $testseries->id)->get();
                $count_time = 0;
                foreach ($times as $time) {
                    $count_time = $count_time + $time->ques_time;
                }
                $testseriesArray[$k]['user_name'] = $testseries->user ? $testseries->user->name : '';
                $testseriesArray[$k]['subject'] = $testseries->subject->name;
                $testseriesArray[$k]['name'] = $testseries->name;
                $testseriesArray[$k]['total_ques'] = $testseries->total_question;
                // $testseriesArray[$k]['lang'] = $testseries->lang;
                if ($testseries->is_approve == 2) {
                    $testseriesArray[$k]['status'] = '<label class="btn btn-success btn-xs disabled">Approved</label>';
                } elseif ($testseries->is_approve == 3) {
                    $testseriesArray[$k]['status'] = '<label class="btn btn-danger btn-xs disabled">Rejected</label>';
                } else {
                    $testseriesArray[$k]['status'] = '<a href="javaScript:void(0);" class="btn btn-success btn-xs accept_ques" id="' . $testseries->id . '" data-status="' . $testseries->is_approve . '"><i class="fa fa-check"></i> Accept </a>&nbsp;&nbsp;'
                            . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs reject_ques" id="' . $testseries->id . '" data-status="' . $testseries->is_approve . '"><i class="fa fa-times"></i> Reject </a>';
                }
                $testseriesArray[$k]['action'] = '<a href="' . route('admin.test-series.edit', $testseries) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;'
                        . '<a href="' . route('admin.test-series.question-list', $testseries) . '" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> View Questions </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                        . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $testseries->id . '" ><i class="fa fa-trash"></i> Delete </a>';
                $testseriesArray[$k]['series_time'] = $count_time . " Sec";
            }

            $data['data'] = $testseriesArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
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

    public function testSeriesDelete(Request $request) {
        try {
            $testseries = TestSeries::find($request->id);
            if ($testseries) {
                $testseries->delete();
                $ques = Question::where('test_series_id', $testseries->id)->get();
                Question::where('test_series_id', $testseries->id)->delete();
                Invite::where('test_series_id', $testseries->id)->delete();
                foreach ($ques as $que) {
                    Answer::where('question_id', $que->id)->delete();
                }
                return ['status' => true, "message" => "Question deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function testSeriesEdit(Request $request, Testseries $testseries) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'testseries_name' => [
                                'bail',
                                'required',
                                Rule::unique('test_series', 'name')->ignore($testseries->id)->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->testseries_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.test-series.edit', $testseries->id)->withErrors($validator)->withInput();
                }

                $testseries->name = $request->testseries_name;
                $testseries->subject_id = $request->subject_id;

                if ($testseries->save()) {
                    $ques = Question::where('test_series_id', $testseries->id)->update(['subject_id' => $request->subject_id]);
                    return redirect()->route('admin.test-series.index')->with('status', 'Test Series has been updated successfully.');
                } else {
                    return redirect()->route('admin.test-series.index')->with('error', 'Something went be wrong.');
                }
            }
            $subjects = Subject::get();
            $exams = Exam::get();
            return view('admin.test-series.edit', [
                'series' => $testseries,
                'subjects' => $subjects,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.test-series.index')->with('error', $ex->getMessage());
        }
    }

    public function testSeriesAdd(Request $request) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'testseries_name' => [
                                'bail',
                                'required',
                                Rule::unique('test_series', 'name')->where(function ($query) use($request) {
                                            return $query->where(['name' => $request->testseries_name])
                                                            ->whereNull('deleted_at');
                                        }),
                            ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.test-series.add')->withErrors($validator)->withInput();
                }
                $testseries = new TestSeries();
                $testseries->user_id = auth()->user()->id;
                $testseries->is_approve = 2;
                $testseries->name = $request->testseries_name;
                $testseries->exam_id = 0;
                $testseries->subject_id = $request->subject_id;
                $testseries->lang = $request->lang_type;
                $testseries->total_question = $request->total_question;
                if ($testseries->save()) {

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
                        $question->exam_id = $request->exam_id;
                        $question->subject_id = $request->subject_id;
                        $question->test_series_id = $testseries->id;
                        $question->lang = $request->lang_type;
                        $question->is_approve = 2;
                        $question->quiz_id = 0;
                        $question->description = $ques;

                        $question->ques_time = $request->time[$k];

                        if ($question->save()) {

                            $questionExam = new QuestionExam();
                            $questionExam->exam_id = $request->exam_id;
                            $questionExam->question_id = $question->id;
                            $questionExam->save();

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
                    return redirect()->route('admin.test-series.index')->with('status', 'Test Series has been updated successfully.');
                } else {
                    return redirect()->route('admin.test-series.index')->with('error', 'Something went wrong.');
                }
            }

            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];
            $subjects = Subject::get();
            $exams = Exam::get();
            return view('admin.test-series.add', [
                'subjects' => $subjects,
                'exams' => $exams,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.test-series.index')->with('error', $ex->getMessage());
        }
    }

    public function acceptTestSeries(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $question = TestSeries::findOrFail($request->record_id);
                $question->is_approve = $request->status;
                if ($question->save()) {
                    $ques = Question::where('test_series_id', $question->id)->get();
                    foreach ($ques as $que) {
                        $upte = Question::find($que->id);
                        $upte->is_approve = 2;
                        $upte->save();
                    }
                    $user = User::where('id', $question->user_id)->first();
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "Test Series Approve successfully.");
                        $this->androidPushNotification(2, "Quizz Application", "Test Series Approve successfully.", $user->device_token, 4, $this->notificationCount($user->id), $question->id);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Test Series Approve successfully."]];
                } else {
                    return ['status' => false, "message" => "Something went be wrong."];
                }
            } else {
                return ['status' => false, "message" => "Method not allowed."];
            }
        } catch (\Exception $e) {
            return ['status' => false, "message" => $e->getMessage()];
        }
    }

    public function rejectTestSeries(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $question = TestSeries::findOrFail($request->record_id);
                $question->is_approve = $request->status;
                if ($question->save()) {
                    $ques = Question::where('test_series_id', $request->record_id)->get();
                    foreach ($ques as $que) {
                        $upte = Question::findOrFail($que->id);
                        $upte->is_approve = 3;
                        $upte->save();
                    }
                    $user = User::where('id', $question->user_id)->first();
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "Test Series Rejected.");
                        $this->androidPushNotification(2, "Quizz Application", "Test Series Rejected.", $user->device_token, 4, $this->notificationCount($user->id), $question->id);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Test Series Rejected."]];
                } else {
                    return ['status' => false, "message" => "Something went be wrong."];
                }
            } else {
                return ['status' => false, "message" => "Method not allowed."];
            }
        } catch (\Exception $e) {
            return ['status' => false, "message" => $e->getMessage()];
        }
    }

    public function testSeriesQuestionList(Request $request, Testseries $testseries) {
        $css = [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        ];
        $js = [
            'bower_components/datatables.net/js/jquery.dataTables.min.js',
            'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
        ];

        $questions = Question::where("test_series_id", $testseries->id)->get();
        return view('admin.test-series.question-list', [
            'questions' => $questions,
            'testseries' => $testseries,
            'css' => $css,
            'js' => $js,
        ]);
    }

    public function testSeriesQuestionAdd(Request $request, Testseries $testseries) {

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
                $question->exam_id = $request->exam_id;
                $question->subject_id = $request->subject_id;
                $question->test_series_id = $testseries->id;
                $question->lang = $request->lang_type;
                $question->quiz_id = 0;
                $question->description = $ques;
                $question->ques_time = $request->time[$k];

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
            return redirect()->route('admin.test-series.index')->with('status', 'Question added successfully.');
        }

        return view('admin.test-series.question-add', [
            'testseries' => $testseries,
        ]);
    }

    public function testSeriesQuestionEdit(Request $request, Question $question) {

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
                    Answer::where('id', $request->ansval1)->update(['description' => $request->ans1, 'is_answer' => 1]);
                    Answer::where('id', $request->ansval2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt2") {
                    Answer::where('id', $request->ansval1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval2)->update(['description' => $request->ans2, 'is_answer' => 1]);
                    Answer::where('id', $request->ansval3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt3") {
                    Answer::where('id', $request->ansval1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval3)->update(['description' => $request->ans3, 'is_answer' => 1]);
                    Answer::where('id', $request->ansval4)->update(['description' => $request->ans4, 'is_answer' => 0]);
                }
                if ($request->correct_answer == "opt4") {
                    Answer::where('id', $request->ansval1)->update(['description' => $request->ans1, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval2)->update(['description' => $request->ans2, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval3)->update(['description' => $request->ans3, 'is_answer' => 0]);
                    Answer::where('id', $request->ansval4)->update(['description' => $request->ans4, 'is_answer' => 1]);
                }
                return redirect()->route('admin.test-series.index')->with('status', 'Question has been updated successfully.');
            }
        }

        $answers = Answer::where('question_id', $question->id)->get();
        return view('admin.test-series.question-edit', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }

}
