<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * @api {get} /api/terms-conditions Terms Conditions
     * @apiHeader {String} Accept application/json.
     * @apiName GetTermsConditions
     * @apiGroup CMS
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Terms Conditions.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *      "status":true,
     *      "status_code":200,
     *      "message":"Terms Conditions",
     *      "data":
     *          {
     *              "title":"I UNDERSTAND THAT HOPE WILL NOT USE MY PERSONAL DATA IN ANY WAY.",
     *              "content":"<ol>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <\/ol>"
     *          }
     *   }
     *
     *
     */
    public function termContidion(Request $request)
    {
        // $data['title'] = "I UNDERSTAND THAT HOPE WILL NOT USE MY PERSONAL DATA IN ANY WAY.";
        // $data['content'] = "<ol>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // </ol>";
        // return $this->successResponse("Terms Conditions", $data);
        try {
            $cms = Cms::find(1);
            $data['title'] = $cms->title;
            $data["content"] = $cms->description;
            return $this->successResponse("Terms Conditions", $data);
        } catch (\Exception $ex) {
            return $this->errorResponse("t&c not found.");
        }
    }

    /**
     * @api {get} /api/privacy-policy Privacy Policy
     * @apiHeader {String} Accept application/json.
     * @apiName GetPrivacyPolicy
     * @apiGroup CMS
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Privacy Policy.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *      "status":true,
     *      "status_code":200,
     *      "message":"Privacy Policy",
     *      "data":
     *          {
     *              "content":"<ol>\n   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\/li>\n        <\/ol>"
     *          }
     *   }
     *
     *
     */
    public function privacyPolicy(Request $request)
    {
        // $data['title'] = "Privacy Policy.";
        // $data['content'] = "<ol>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</li>
        // </ol>";
        // return $this->successResponse("Privacy Policy", $data);
        try {
            $cms = Cms::find(2);
            $data["content"] = $cms->description;
            // $data["last_updated"] = $cms->updated_at;
            return $this->successResponse("Privacy Policy", $data);
        } catch (\Exception $ex) {
            return $this->errorResponse("Privacy Policy not found.");
        }
    }

    /**
     * @api {get} /api/contact-us Contact Us
     * @apiHeader {String} Accept application/json.
     * @apiName GetContactUs
     * @apiGroup CMS
     *
     *
     * @apiSuccess {String} success true
     * @apiSuccess {String} status_code (200 => success, 404 => Not found or failed).
     * @apiSuccess {String} message Contact Us.
     * @apiSuccess {JSON} data Array.
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *   {
     *      "status":true,
     *      "status_code":200,
     *      "message":"Contact Us",
     *      "data":
     *          {
     *              "number":"+911234567890",
     *              "email":"info@quizz.com"
     *          }
     *   }
     *
     *
     */
    public function contactUs(Request $request)
    {
        // $data['number'] = "+911234567890";
        // $data['email'] = "info@quizz.com";
        // return $this->successResponse("Contact Us", $data);

        try {
            $cms = Cms::find(3);
            $data["number"] = $cms->description;
            $data["email"] = $cms->title;
            return $this->successResponse("Contact Us", $data);
        } catch (\Exception $ex) {
            return $this->errorResponse("Contact Us not found.");
        }
    }

}
