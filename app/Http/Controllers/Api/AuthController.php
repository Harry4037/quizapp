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
            $existingUser = User::where(['user_type_id' => $request->user_type, 'mobile_number' => $request->mobile_number])->first();
            if ($existingUser) {
                $existingUser->otp = $otp;
                $existingUser->is_active = 1;
                if ($existingUser->save()) {
                    return $this->successResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->errorResponse("Something went wrong.", (object) []);
                }
            } else {

                $user = new User();
                $user->mobile_number = $request->mobile_number;
                $user->user_type_id = $request->user_type;
                $user->lang = $request->lang;
                $user->otp = $otp;
                if ($request->device_token) {
                    $user->device_token = $request->device_token;
                }
                $user->is_active = 1;
                if ($user->save()) {
                    return $this->successResponse("OTP sent successfully.", (object) []);
                } else {
                    return $this->errorResponse("Something went wrong.", (object) []);
                }
            }
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
     *         "user_detail": {
     *               "id": 2,
     *               "name": "Hariom gangwar",
     *           }
     *      }
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
        $user = User::where(["mobile_number" => $request->mobile_number, "user_type_id" => $request->user_type, "otp" => $request->otp])->first();
        if ($user) {
            $data['user_detail']['id'] = $user->id;
            $data['user_detail']['mobile_number'] = $user->mobile_number;
            $data['user_detail']['profile_pic'] = $user->profile_pic ? $user->profile_pic : '';
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
