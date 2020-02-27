<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'user_type_id');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

        if (Auth::guard()->check()) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $request->merge(["user_type_id" => 1]);
        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    public function profile(Request $request) {
        try {

            if ($request->isMethod("post")) {
                $validator = Validator::make($request->all(), [
                            'profile_pic' => ['mimes:jpeg,jpg,png'],
                ]);
                if ($validator->fails()) {
                    return redirect()->route('admin.profile')->withErrors($validator)->withInput();
                }

                $user = User::find(auth()->user()->id);
                if ($request->hasFile('profile_pic')) {
                    $userImg = User::selectRaw('profile_pic img')->find($user->id);
                    Storage::disk('public')->delete('profile_pic/' . $userImg->img);
                    $profile_pic = $request->file("profile_pic");
                    $userImage = Storage::disk('public')->put('profile_pic', $profile_pic);
                    $user_file_name = basename($userImage);
                    $user->profile_pic = $user_file_name;
                }
                $user->name = $request->name;
                $user->designation = $request->designation;
                $user->into_line = $request->into_line;

                if ($user->save()) {

                    return redirect()->route('admin.profile')->with('status', 'Profile has been updated successfully.');
                } else {
                    return redirect()->route('admin.profile')->with('error', 'Something went be wrong.');
                }
            }

            return view('admin.profile');
        } catch (\Exception $ex) {
            return redirect()->route('admin.dashboard')->with('error', $ex->getMessage());
        }
    }
    public function changePassword(Request $request)
    {
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'bail|required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/',
                'confirm_password' => 'required',
            ], [
                'new_password.regex' => "New password must be minimum six character, One numeric digit, One special character, One uppercase and One lowercase letter.",
            ]);
            if ($validator->fails()) {
                return redirect()->route('admin.change-password')->withErrors($validator)->withInput();
            }

            $user = User::find(auth()->user()->id);
            if (Hash::check($request->get("old_password"), $user->password)) {
                $user->password = $request->get("new_password");
                $user->save();
                return redirect()->route('admin.change-password')->with('status', 'Password has been updated successfully.');
            } else {
                return redirect()->route('admin.change-password')->with('error', 'Old password incorrect.');
            }
        }
        return view('admin.change-password');
    }

}
