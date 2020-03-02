<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class CreatorController extends Controller
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
        return view('admin.creator.index', [
            'js' => $js,
            'css' => $css,
        ]);
    }

    public function userList(Request $request)
    {
        try {
            $offset = $request->get('start') ? $request->get('start') : 0;
            $limit = $request->get('length');
            $searchKeyword = $request->get('search')['value'];

            $query = User::query()->where("user_type_id", 2);
            if ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where("name", "LIKE", "%$searchKeyword%")
                        ->orWhere("email", "LIKE", "%$searchKeyword%")
                        ->orWhere("mobile_number", "LIKE", "%$searchKeyword%");
                });
            }
            $data['recordsTotal'] = $query->count();
            $data['recordsFiltered'] = $query->count();
            $users = $query->take($limit)->offset($offset)->latest()->get();

            $usersArray = [];
            foreach ($users as $k => $user) {
                $usersArray[$k]['image_name'] = '<img class="img-bordered" height="60" width="100" src=' . $user->profile_pic . '>';
                $usersArray[$k]['mobile_number'] = $user->mobile_number;
                $usersArray[$k]['name'] = $user->name;
                $usersArray[$k]['email'] = $user->email;
                $usersArray[$k]['lang'] = $user->lang;
                $checked_status = $user->is_active ? "checked" : '';
                $usersArray[$k]['status'] = "<label class='switch'><input  type='checkbox' class='user_status' id=" . $user->id . " data-status=" . $user->is_active . " " . $checked_status . "><span class='slider round'></span></label>";
                if ($user->is_approve == 2) {
                    $usersArray[$k]['approval'] = '<label class="btn btn-success btn-xs disabled">Approved</label>';
                } elseif ($user->is_approve == 3) {
                    $usersArray[$k]['approval'] = '<label class="btn btn-danger btn-xs disabled">Rejected</label>';
                } else {
                    $usersArray[$k]['approval'] = '<a href="javaScript:void(0);" class="btn btn-success btn-xs accept_creator" id="' . $user->id . '" data-status="' . $user->is_approve . '"><i class="fa fa-check"></i> Accept </a>&nbsp;&nbsp;'
                    . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs reject_creator" id="' . $user->id . '" data-status="' . $user->is_approve . '"><i class="fa fa-times"></i> Reject </a>';
                }
                $usersArray[$k]['action'] = '<a href="' . route('admin.creator.edit', $user) . '" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>&nbsp;&nbsp;'
                . '<a href="javaScript:void(0);" class="btn btn-danger btn-xs delete" id="' . $user->id . '" ><i class="fa fa-trash"></i> Delete </a>';
            }

            $data['data'] = $usersArray;
            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function userDelete(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user) {
                $user->delete();
                return ['status' => true, "message" => "Creator deleted."];
            } else {
                return ['status' => false, "message" => "Something went be wrong."];
            }
        } catch (\Exception $ex) {
            return ['status' => false, "message" => $ex->getMessage()];
        }
    }

    public function userEdit(Request $request, User $user)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'profile_pic' => ['mimes:jpeg,jpg,png'],
                    'user_name' => ['required'],
                    'lang_type' => ['required'],

                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.creator.edit', $user->id)->withErrors($validator)->withInput();
                }

                if ($request->hasFile('profile_pic')) {
                    $userImg = User::selectRaw('profile_pic img')->find($user->id);
                    Storage::disk('public')->delete('profile_pic/' . $userImg->img);
                    $profile_pic = $request->file("profile_pic");
                    $userImage = Storage::disk('public')->put('profile_pic', $profile_pic);
                    $user_file_name = basename($userImage);
                    $user->profile_pic = $user_file_name;
                }
                $user->name = $request->user_name;
                $user->email = $request->user_email;
                $user->lang = $request->lang_type;
                $user->designation = $request->designation;
                $user->qualification = $request->qualification;
                $user->dob = date('Y-m-d', strtotime($request->dob));
                $user->into_line = $request->about;
                if ($user->save()) {
                    return redirect()->route('admin.creator.index')->with('status', 'Creator has been updated successfully.');
                } else {
                    return redirect()->route('admin.creator.index')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];
            return view('admin.creator.edit', [
                'user' => $user,
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.creator.index')->with('error', $ex->getMessage());
        }
    }

    public function userStatus(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = User::findOrFail($request->record_id);
                $user->is_active = $request->status;
                if ($user->save()) {
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Status updated successfully."]];
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

    public function userAdd(Request $request)
    {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                    'mobile_number' => [
                        'bail',
                        'required',
                        Rule::unique('users', 'mobile_number')->where(function ($query) use ($request) {
                            return $query->where(['mobile_number' => $request->mobile_number, 'user_type_id' => 2])
                                ->whereNull('deleted_at');
                        }),
                    ],
                    'profile_pic' => ['mimes:jpeg,jpg,png'],
                    'user_name' => ['required'],
                    'lang_type' => ['required'],

                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.creator.add')->withErrors($validator)->withInput();
                }
                $user = new User();
                if ($request->hasFile('profile_pic')) {
                    $profile_pic = $request->file("profile_pic");
                    $userImage = Storage::disk('public')->put('profile_pic', $profile_pic);
                    $user_file_name = basename($userImage);
                    $user->profile_pic = $user_file_name;
                }
                $user->user_type_id = 2;
                $user->is_active = 1;
                $user->mobile_number = $request->mobile_number;
                $user->email = $request->user_email;
                $user->name = $request->user_name;
                $user->lang = $request->lang_type;
                $user->designation = $request->designation;
                $user->qualification = $request->qualification;
                $user->dob = date('Y-m-d', strtotime($request->dob));
                $user->into_line = $request->about;
                $user->created_by = auth()->user()->id;
                $user->updated_by = auth()->user()->id;

                if ($user->save()) {
                    return redirect()->route('admin.creator.index')->with('status', 'Creator has been added successfully.');
                } else {
                    return redirect()->route('admin.creator.index')->with('error', 'Something went be wrong.');
                }
            }
            $css = [
                'bower_components/bootstrap-daterangepicker/daterangepicker.css',
            ];
            $js = [
                'bower_components/moment/min/moment.min.js',
                'bower_components/bootstrap-daterangepicker/daterangepicker.js',
            ];
            return view('admin.creator.add', [
                'css' => $css,
                'js' => $js,
            ]);
        } catch (\Exception $ex) {
            return redirect()->route('admin.creator.index')->with('error', $ex->getMessage());
        }
    }

    public function checkMobileNumber(Request $request)
    {
        $existing = User::where(['mobile_number' => $request->mobile_number, 'user_type_id' => 2])->first();
        if ($existing) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function acceptCreator(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = User::findOrFail($request->record_id);
                $user->is_approve = $request->status;
                if ($user->save()) {

                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "You are successfully Approved By Admin");
                        $this->androidPushNotification(2, "Quizz Application", "You are successfully Approved", $user->device_token, 1, $this->notificationCount($user->id), 2);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Creator Approve successfully."]];
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

    public function rejectCreator(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $user = User::findOrFail($request->record_id);
                $user->is_approve = $request->status;
                $user->user_type_id = 3;
                if ($user->save()) {
                    if ($user && $user->device_token) {
                        $this->generateNotification($user->id, 1, "Quizz Application", "You are Rejected By Admin");
                        $this->androidPushNotification(2, "Quizz Application", "You are Rejected", $user->device_token, 1, $this->notificationCount($user->id), 3);
                    }
                    return ['status' => true, 'data' => ["status" => $request->status, "message" => "Creator Rejected."]];
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

}
