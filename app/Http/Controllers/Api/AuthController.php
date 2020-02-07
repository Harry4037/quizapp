<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class AuthController extends Controller {

    /**
     * @api {post} /api/send-otp  Send OTP
     * @apiHeader {String} Accept application/json.
     * @apiName PostSendOtp
     * @apiGroup Auth
     *
     * @apiParam {String} mobile_number User unique mobile number*.
     * @apiParam {String} user_type User type*. (Creator => 2, User => 3).
     * @apiParam {String} lang language. (English => 1, Hindi => 2).
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message OTP sent successfully.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "OTP sent successfully.",
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
    public function sendOTP(Request $request) {
        if (!$request->mobile_number) {
            return $this->errorResponse("Mobile number missing");
        }
        if (!$request->user_type) {
            return $this->errorResponse("User type missing");
        }
        if (!$request->lang) {
            return $this->errorResponse("Language missing");
        }


        $otp = 1234;
//        $otp = rand(1000, 9999);
        if (($request->user_type == 2) || ($request->user_type == 3)) {

            if($request->user_type == 2){
                $existingUser = User::where(['is_active' => 0 ,'mobile_number' => $request->mobile_number])->first();
            if ($existingUser) {
                $existingUser->otp = $otp;
                // if ($request->user_type == 3) {
                //     $existingUser->is_active = 0;
                // } else {
                //     $existingUser->is_active = 1;
                // }

                if ($existingUser->save()) {
                    return $this->successResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->errorResponse("Something went wrong.", (object) []);
                }
            } else {
                return $this->errorResponse("Your are Blocked by us.", (object) []);

            }}
            if($request->user_type == 3){
                $existingUser = User::where(['mobile_number' => $request->mobile_number])->first();
            if ($existingUser) {
                $existingUser->otp = $otp;
                // if ($request->user_type == 3) {
                //     $existingUser->is_active = 0;
                // } else {
                //     $existingUser->is_active = 1;
                // }

                if ($existingUser->save()) {
                    return $this->successResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->errorResponse("Something went wrong.", (object) []);
                }
            } else {
                return $this->errorResponse("Your are not registered with us.", (object) []);

            }}

        }

        return $this->errorResponse("Incorrect user type.");
    }

    /**
     * @api {post} /api/verify-otp  Verify OTP
     * @apiHeader {String} Accept application/json.
     * @apiName PostVerifyOtp
     * @apiGroup Auth
     *
     * @apiParam {String} mobile_number User unique mobile number*.
     * @apiParam {String} user_type User type*. (User => 3).
     * @apiParam {String} otp OTP*.
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message OTP verified successfully.
     * @apiSuccess {JSON} data blank object.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *       "status": true,
     *       "status_code": 200,
     *       "message": "OTP verified successfully.",
     *       "data": {
     *           "user_detail": {
     *               "id": 2,
     *               "name": "Hariom",
     *               "email": "hariom@mail.com",
     *               "mobile_number": "8077575835",
     *               "dob": "1991-02-04",
     *               "designation": "Student",
     *               "qualification": "M.Com",
     *               "about": "Lorem ipsum",
     *               "experience": "2 Year",
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
     * @apiError OTPMissing The OTP is missing.
     * @apiErrorExample Error-Response:
     * HTTP/1.1 404 Not Found
     *  {
     *     "status": false,
     *     "status_code": 404,
     *     "message": "OTP missing.",
     *     "data": {}
     *  }
     *
     *
     */
    public function verifyOTP(Request $request) {
        if (!$request->mobile_number) {
            return $this->errorResponse("Mobile number missing");
        }
        if (!in_array($request->user_type, [2, 3])) {
            return $this->errorResponse("User type missing");
        }
        if (!$request->otp) {
            return $this->errorResponse("OTP missing");
        }
        $user = User::where(["mobile_number" => $request->mobile_number, "otp" => $request->otp])->first();
        if ($user) {
            $data['user_detail'] = $user;
            $data['user']['following'] = 10;
            $data['user']['follower'] = 50;
            $data['user']['post'] = 35;
            return $this->successResponse("OTP verified successfully.", $data);
        } else {
            return $this->errorResponse("Incorrect OTP.", (object) []);
        }
    }

    public function logout() {
        try {
            auth('api')->logout();
            return $this->successResponse("Logout successfully.", (object) []);
        } catch (Exception $ex) {
            return $this->successResponse("Logout successfully.", (object) []);
        }
    }

}
