<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionComment;
use App\Models\QuestionExam;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class QuestionController extends Controller
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
        return view('admin.question.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function questionList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = Question::query()->with('subject')->where('is_approve', '!=', null);
            $query->where(function ($query) {
                $query->where(["quiz_id" => 0]);
            });
            if ($searchKeyword) {
                $query->whereHas("subject", function ($query) use ($searchKeyword) {
                    $query->where("name", "LIKE", "%$searchKeyword%");
                });
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $questions = $query->take($limit)->offset($offset)->latest()->get();

            $questionsArray = [];
            foreach ($questions as $k => $question) {
                $questionsArray[$k]['description'] = $question->description;
                $questionsArray[$k]['subject'] = $question->subject ? $question->subject->name : '';
                if ($question->is_approve == 2) {
                    $questionsArray[$k]['status'] = '<label class="btn btn-success btn-xs disabled">Approved</label>';
                } elseif ($question->is_approve == 3) {
                    $questionsArray[$k]['status'] = '<label class="btn btn-danger btn-xs disabled">Rejected</label>';
                } else {
                    $questionsArray[$k]['status'] = '<a href="javaScript:void(0);" class="btn btn-success btn-xs accept_ques" id="' . $question->id . '" data-status="' . $question->is_approve . '"><i class="fa fa-check"></i> Accept </a>&nbsp;&nbsp;'
                    . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs reject_ques" id="' . $question->id . '" data-status="' . $question->is_approve . '"><i class="fa fa-times"></i> Reject </a>';
                }
                $questionsArray[$k]['action'] = '<a href="' . route('admin.question.edit', $question) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;&nbsp;<a href="' . route('admin.question.comment-list', $question) . '" class="btn btn-warning btn-xs"><i class="fa fa-comment"></i> Comment </a>&nbsp;&nbsp;&nbsp;'
                . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $question->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $questionsArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function questionDelete(Request $request)
    {
        try {
            $question = Question::find($request->id);
            if ($question) {
                $question->delete();
                Answer::where('question_id', $request->id)->delete();
                QuestionExam::where('question_id', $request->id)->delete();
                return ['status' => true, "message" => "Question deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function questionEdit(Request $request, Question $question)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'description' => [
                        'bail',
                        'required',
                        'description' => ['required'],
                        Rule::unique('questions', 'description')->ignore($question->id)->where(function ($query) use ($request) {
                            return $query->where(['description' => $request->description])
                                ->whereNull('deleted_at');
                        }),
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.question.edit', $question->id)->withErrors($validator)->withInput();
                }
                if ($request->hasFile('ques_image')) {
                    $quesImg = Question::selectRaw('ques_image img')->find($question->id);
                    Storage::disk('public')->delete('ques_image/' . $quesImg->img);
                    $ques_image = $request->file("ques_image");
                    $quesImage = Storage::disk('public')->put('ques_image', $ques_image);
                    $ques_file_name = basename($quesImage);
                    $question->ques_image = $ques_file_name;
                }
                $question->exam_id = 0;
                $question->subject_id = $request->subject_id;
                $question->description = $request->description;
                $question->lang = $request->lang_type;
                $question->ques_time = $request->time;
                $question->year = $request->year;
                if ($question->save()) {

                    if (!$request->exam_id) {
                        $exams = Exam::pluck("id")->toArray();
                    } else {
                        $exams = $request->exam_id;
                    }

                    QuestionExam::where("question_id", $question->id)->delete();
                    foreach ($exams as $exam) {
                        $questionExam = new QuestionExam();
                        $questionExam->question_id = $question->id;
                        $questionExam->exam_id = $exam;
                        $questionExam->save();
                    }

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
                    return redirect()->route('admin.question.index')->with('status', 'Question has been updated successfully.');
                } else {
                    return redirect()->route('admin.question.index')->with('error', 'Something went be wrong.');
                }
            }
            $subjects = Subject::get();
            $exams1 = Exam::get();
            $answers = Answer::where('question_id', $question->id)->get();
            $questionExam = QuestionExam::where('question_id', $question->id)->pluck("exam_id")->toArray();
//            dd($questionExam);
            $css = [
                'bower_components/select2/dist/css/select2.min.css',
            ];
            $js = [
                'bower_components/select2/dist/js/select2.min.js',
            ];
            return view('admin.question.edit', [
                'question' => $question,
                'subjects' => $subjects,
                'exams1' => $exams1,
                'answers' => $answers,
                'questionExam' => $questionExam,
                'js' => $js,
                'css' => $css,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.question.index')->with('error', $ex->getMessage());
        }
    }

    public function questionAdd(Request $request)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'description' => [
                        'required',
                        Rule::unique('questions', 'description')->where(function ($query) use ($request) {
                            return $query->where(['description' => $request->description])
                                ->whereNull('deleted_at');
                        }),
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.question.add')->withErrors($validator)->withInput();
                }
                if (!$request->exam_id) {
                    $exams = Exam::pluck("id")->toArray();
                } else {
                    $exams = $request->exam_id;
                }

                $question = new Question();
                $question->ques_time = $request->time;
                $question->user_id = 1;
                $question->is_approve = 2;
                $question->description = $request->description;
                $question->exam_id = 0;
                $question->year = $request->year;
                $question->lang = $request->lang_type;
                $question->subject_id = $request->subject_id;
                if ($request->hasFile('ques_image')) {
                    $ques_image = $request->file("ques_image");
                    $quesImage = Storage::disk('public')->put('ques_image', $ques_image);
                    $ques_file_name = basename($quesImage);
                    $question->ques_image = $ques_file_name;
                }
                if ($question->save()) {

                    foreach ($exams as $exam) {
                        $questionExam = new QuestionExam();
                        $questionExam->question_id = $question->id;
                        $questionExam->exam_id = $exam;
                        $questionExam->save();
                    }
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans1;
                    if ($request->correct_answer == "opt1") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans2;
                    if ($request->correct_answer == "opt2") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans3;
                    if ($request->correct_answer == "opt3") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->description = $request->ans4;
                    if ($request->correct_answer == "opt4") {
                        $answer->is_answer = 1;
                    } else {
                        $answer->is_answer = 0;
                    }
                    $answer->save();
                }

                return redirect()->route('admin.question.index')->with('status', 'Question has been updated successfully.');
            }
            $css = [
                'bower_components/select2/dist/css/select2.min.css',
            ];
            $js = [
                'bower_components/select2/dist/js/select2.min.js',
            ];
            $subjects = Subject::get();
            $exams = Exam::get();
            return view('admin.question.add', [
                'subjects' => $subjects,
                'exams' => $exams,
                'js' => $js,
                'css' => $css,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.question.index')->with('error', $ex->getMessage());
        }
    }

    public function acceptQues(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $question = Question::findOrFail($request->record_id);
                $question->is_approve = $request->status;
                if ($question->save()) {
                    $user = User::Where('id', $question->user_id)->first();
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "Your Question are successfully Approved");
                        $this->androidPushNotification(2, "Quizz Application", "Your Question are successfully Approved", $user->device_token, 2, $this->notificationCount($user->id), $question->id);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Question Approve successfully."]];
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

    public function rejectQues(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $question = Question::findOrFail($request->record_id);
                $question->is_approve = $request->status;
                if ($question->save()) {
                    $user = User::Where('id', $question->user_id)->first();
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "Your Question are Rejected");
                        $this->androidPushNotification(2, "Quizz Application", "Your Question are Rejected", $user->device_token, 2, $this->notificationCount($user->id), $question->id);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Question Rejected."]];
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

    public function comment(Request $request, Question $question)
    {

        $comm = QuestionComment::where('question_id', $question->id)->with(['user'])->get();
        return view('admin.question.comment-list', [
            'comments' => $comm,
            'question' => $question,
        ]);
    }

    public function commentAdd(Request $request, Question $question)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'message' => [
                        'bail',
                        'required',
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.question.comment-list', $question)->withErrors($validator)->withInput();
                }
                $quescom = new QuestionComment();

                $quescom->user_id = 1;
                $quescom->question_id = $request->question->id;
                $quescom->description = $request->message;

                if ($quescom->save()) {
                    $comm = Question::where('id', $request->question->id)->first();
                    $user = User::where('id', $comm->user_id)->first();
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "Admin Has Comment On Your Question.");
                        $this->androidPushNotification(2, "Quizz Application", "Admin Has Comment On Your Question.", $user->device_token, 5, $this->notificationCount($user->id), $request->question->id);
                    }
                    return redirect()->route('admin.question.comment-list', $question)->with('status', 'Comment has been Added successfully.');

                } else {
                    return redirect()->route('admin.question.comment-list', $question)->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.question.comment-add', [
                'question' => $question,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.question.comment-list', $question)->with('error', $ex->getMessage());
        }
    }

}
