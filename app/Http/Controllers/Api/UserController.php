<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\UserExam;
use Illuminate\Support\Facades\Storage;

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
     * @apiParam {String} profile_pic User Profile pic.(File Type)
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
        if ($request->profile_pic) {
            if (!$request->hasFile("profile_pic")) {
                return $this->errorResponse("Profile pic not valid file type.");
            }
            $profile_pic = $request->file("profile_pic");
            $profile = Storage::disk('public')->put('profile_pic', $profile_pic);
            $profile_file_name = basename($profile);

            $user->profile_pic = $profile_file_name;
        }
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
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "user Profile.",
     *       "data": {
     *           "user_profile": {
     *               "id": 2,
     *               "name": "Hariom",
     *               "email": "hariom@mail.com",
     *               "mobile_number": "8077575835",
     *               "dob": "1991-02-04",
     *               "designation": "Student",
     *               "qualification": "M.Com",
     *               "into_line": null,
     *               "lang": 1,
     *               "user_type_id": 2,
     *               "otp": "12345",
     *               "profile_pic": "http://127.0.0.1:8000/storage/profile_pic/1hbKjNG9nhvNTtJtWMn2t7hlsSE6GLsuKqtp3scX.jpeg",
     *               "device_token": null,
     *               "latitude": null,
     *               "longitude": null,
     *               "is_active": 1,
     *               "email_verified_at": null,
     *               "created_by": "0",
     *               "updated_by": "0",
     *               "created_at": "2020-01-13 06:57:03",
     *               "updated_at": "2020-01-13 06:57:03",
     *               "deleted_at": null
     *           },
     *           "user": {
     *               "following": 10,
     *               "follower": 50,
     *               "post": 35
     *           }
     *       }
     *   }
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
            $data['user']['following'] = 10;
            $data['user']['follower'] = 50;
            $data['user']['post'] = 35;
            return $this->successResponse("user Profile.", $data);
        } else {
            return $this->errorResponse("User not found.");
        }
    }

    /**
     * @api {post} /api/update-language Update Language
     * @apiHeader {String} Accept application/json.
     * @apiName PostUpdateLanguage
     * @apiGroup User
     *
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} lang User language*. (English => 1, Hindi => 2)
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Language Changed Successfully.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Language Changed Successfully.",
     *       "data": {
     *           "user_detail": {
     *               "id": 1,
     *               "name": "Ankit",
     *               "email": "ankit@mail.com",
     *               "mobile_number": "8077575835",
     *               "dob": "2020-01-13",
     *               "designation": "Student",
     *               "qualification": "M.A.",
     *               "lang": "2",
     *               "user_type_id": 1,
     *               "otp": null,
     *               "profile_pic": "http://127.0.0.1:8000/img/no-image.jpg",
     *               "device_token": null,
     *               "latitude": null,
     *               "longitude": null,
     *               "is_active": 1,
     *               "email_verified_at": null,
     *               "created_by": "0",
     *               "updated_by": "0",
     *               "created_at": null,
     *               "updated_at": "2020-01-13 06:19:55",
     *               "deleted_at": null
     *           }
     *       }
     *   }
     *
     * @apiError UserIdMissing The user ID is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User ID missing.",
     *       "data": {}
     *   }
     *
     * @apiError LangMissing The Lang is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Language type missing.",
     *     "data": {}
     *  }
     *
     *
     */
    public function updateLanguage(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        if (!$request->lang) {
            return $this->errorResponse("Language Type Missing.");
        }
        if (!in_array($request->lang, [1, 2])) {
            return $this->errorResponse("Language Type Not Valid.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User Not Found.");
        }
        $user->lang = $request->lang;
        $user->save();
        $data['user_detail'] = $user;
        return $this->successResponse("Language Changed Successfully.", $data);
    }

    /**
     * @api {post} /api/update-exam-selection Update Exam Selection
     * @apiHeader {String} Accept application/json.
     * @apiName PostUpdateExamSelection
     * @apiGroup User
     *
     * @apiParam {String} user_id User ID*.
     * @apiParam {String} exam_id Exam ID's in array format*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Exam's updated successfully.
     * @apiSuccess {JSON} data object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Exam's updated successfully.",
     *       "data": {}
     *   }
     *
     * @apiError UserIdMissing The user ID is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *   {
     *       "status": false,
     *       "status_code": 404,
     *       "message": "User ID missing.",
     *       "data": {}
     *   }
     *
     * @apiError ExamIdMissing The Exam ID is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "Exam ID's missing.",
     *     "data": {}
     *  }
     *
     *
     */
    public function updateExamSelection(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        if (!$request->exam_id) {
            return $this->errorResponse("Exam ID's Missing.");
        }
        if (!is_array($request->exam_id)) {
            return $this->errorResponse("Exam ID's is not in proper format.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User Not Found.");
        }
        UserExam::where("user_id", $user->id)->delete();
        foreach ($request->exam_id as $examID) {
            $userExam = new UserExam();
            $userExam->user_id = $user->id;
            $userExam->exam_id = $examID;
            $userExam->save();
        }

        return $this->successResponse("Exam's updated successfully.", (object) []);
    }

    /**
     * @api {post} /api/user-update  User Update
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeader {String} Accept application/json.
     * @apiName PostUserUpdate
     * @apiGroup User
     *
     * @apiParam {String} name user name*.
     * @apiParam {String} email email.*
     * @apiParam {String} profile_pic picture file.*
     * @apiParam {String} user_id User ID.
     * @apiParam {String} dob Date Of Birth(2020-01-08)*.
     * @apiParam {String} designation Designation*.
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Profile Updated..
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "Profile Updated.",
     *       "data": {
     *          "user": {
     *               "id": 1,
     *               "name": "Ankit",
     *               "email": "ankit@mail.com",
     *               "mobile_number": "8077575835",
     *               "dob": "2020-01-13",
     *               "designation": "Student",
     *               "qualification": "M.A.",
     *               "lang": "2",
     *               "user_type_id": 1,
     *               "otp": null,
     *               "profile_pic": "http://127.0.0.1:8000/img/no-image.jpg",
     *               "device_token": null,
     *               "latitude": null,
     *               "longitude": null,
     *               "is_active": 1,
     *               "email_verified_at": null,
     *               "created_by": "0",
     *               "updated_by": "0",
     *               "created_at": null,
     *               "updated_at": "2020-01-13 06:19:55",
     *               "deleted_at": null
     *          }
     *      }
     *   }
     *
     *
     */
    public function userUpdate(Request $request) {
        if (!$request->user_id) {
            return $this->errorResponse("User ID Missing.");
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return $this->errorResponse("User Not Found.");
        }
        $userArray = [];
        if ($request->profile_pic) {
            if (!$request->hasFile("profile_pic")) {
                return $this->errorResponse("Profile pic not valid file type.");
            }
            $profile_image = $request->file("profile_pic");
            $profile = Storage::disk('public')->put('profile_pic', $profile_image);
            $profile_file_name = basename($profile);
            $userArray['profile_pic'] = $profile_file_name;
        }
        if ($request->name) {
            $userArray['name'] = $request->name;
        }
        if ($request->email) {
            $userArray['email'] = $request->email;
        }
        if ($request->dob) {
            $userArray['dob'] = $request->dob;
        }
        if ($request->designation) {
            $userArray['designation'] = $request->designation;
        }
        $userArray['updated_at'] = new \DateTime("now");
        User::where('id', $request->user_id)->update($userArray);
        $user = User::find($request->user_id);
        $data['user'] = $user;
        return $this->successResponse("Profile Updated.", $data);
    }
}
