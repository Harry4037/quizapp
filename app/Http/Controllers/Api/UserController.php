<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class UserController extends Controller {

    /**
     * @api {post} /api/register  Register User
     * @apiHeader {String} Accept application/json.
     * @apiName PostRegisterUser
     * @apiGroup User
     *
     * @apiParam {String} name User name*.
     * @apiParam {String} email_id User email id*.
     * @apiParam {String} mobile_number User mobile number*.
     * @apiParam {String} dob User Date of Birth*.
     * @apiParam {String} designation User designation*.
     * @apiParam {String} qualification User qualification*.
     * @apiParam {String} lang User language*. (English => 1, Hindi => 2)
     * @apiParam {String} user_type User type*. (Creator => 2, User => 3)
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message User registered successfully.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "User registered successfully.",
     *       "data": {}
     *   }
     *
     * @apiError MobileNumberMissing The mobile number is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "Mobile number missing.",
     *       "data": {}
     *   }
     *
     * @apiError UserTypeMissing The User type is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "User type missing.",
     *     "data": {}
     *  }
     *
     *
     */
    public function userRegister(Request $request) {
        if (!$request->name) {
            return $this->errorResponse("Name missing");
        }
        if (!$request->email_id) {
            return $this->errorResponse("Email ID missing");
        }
        if (!$request->mobile_number) {
            return $this->errorResponse("Mobile number missing");
        }
        if (!$request->dob) {
            return $this->errorResponse("dob missing");
        }
        if (!$request->designation) {
            return $this->errorResponse("Designation missing");
        }
        if (!$request->qualification) {
            return $this->errorResponse("Qualification missing");
        }
        if (!$request->lang) {
            return $this->errorResponse("Language missing");
        }
        if (!in_array($request->lang, [1, 2])) {
            return $this->errorResponse("Select valid language");
        }
        if (!$request->user_type) {
            return $this->errorResponse("User type missing");
        }
        if (!in_array($request->user_type, [2, 3])) {
            return $this->errorResponse("Select valid user type");
        }
        $existingUser = User::where(['user_type_id' => $request->user_type, 'mobile_number' => $request->mobile_number])->first();
        if ($existingUser) {
            return $this->errorResponse("User already registered with us", (object) []);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email_id;
        $user->mobile_number = $request->mobile_number;
        $user->dob = $request->dob;
        $user->designation = $request->designation;
        $user->qualification = $request->qualification;
        $user->lang = $request->lang;
        $user->user_type_id = $request->user_type;

        if ($user->save()) {
            return $this->successResponse("User registered successfully", (object) []);
        } else {
            return $this->errorResponse("Something went wrong.");
        }
    }

    /**
     * @api {get} /api/user-profile  User Profile
     * @apiHeader {String} Accept application/json.
     * @apiName GetUserProfile
     * @apiGroup User
     *
     * @apiParam {String} user_id User ID*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message User Profile.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
        {
            "status": true,
            "status_code": 200,
            "message": "user Profile.",
            "data": {
                "user_profile": {
                    "id": 1,
                    "name": null,
                    "email": null,
                    "mobile_number": "8077575835",
                    "user_type_id": 2,
                    "otp": "1234",
                    "profile_pic": null,
                    "device_token": null,
                    "latitude": null,
                    "longitude": null,
                    "is_active": 1,
                    "email_verified_at": null,
                    "created_by": "0",
                    "updated_by": "0",
                    "created_at": "2019-12-30 08:15:25",
                    "updated_at": "2019-12-30 08:15:25",
                    "deleted_at": null
                }
            }
        }
     *
     * @apiError UserIDMissing The user ID is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User ID missing.",
     *       "data": {}
     *   }
     *
     *
     */
    public function userProfile(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID missing");
        }

        $user = User::where("id", $request->user_id)->first();
        if ($user) {
            $data['user_profile'] = $user;
            return $this->successResponse("user Profile.", $data);
        } else {
            return $this->errorResponse("User not found.");
        }
    }

}
