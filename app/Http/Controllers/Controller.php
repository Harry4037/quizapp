<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Controller extends BaseController
{

    use AuthorizesRequests,
    DispatchesJobs,
        ValidatesRequests;

    public function errorResponse($message)
    {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => $message,
            'data' => (object) [],
        ]);
    }

    public function successResponse($message, $data)
    {
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function generateNotification($user_id, $type, $title, $message)
    {

        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->type = $type;
        $notification->title = $title;
        $notification->message = $message;
        $notification->save();
    }

    public function androidPushNotification($user_type, $title, $message, $token, $notificationType, $count = 0, $record_id = 0)
    {
        config(['fcm.http.server_key' => 'AAAAL6SPjhI:APA91bEWevQCGFbJDxtt0o2mVwDkVo20ZWHEnGGFwW8ER42_4lEfr-FOL7xTtERhqBndBcztbW7bjOTyyuPDke3VfgyT905KHgFVhTPJsSnRgp3bBgj39nd4PzOg8rZ__UtswTc8OwQJ']);
        config(['fcm.http.sender_id' => '204624334354']);
        // $clkAction = 'com.example.quizz.DashBoard.MainActivity';
        if ($notificationType == 0) {
            $clkAction = 'android.intent.action.QUIZ_MAIN_ACTIVITY';
        } elseif ($notificationType == 1) {
            $clkAction = 'android.intent.action.QUIZ_MAIN_ACTIVITY';
        } elseif ($notificationType == 2) {
            $clkAction = 'android.intent.action.QUIZ_MAIN_ACTIVITY';
        } elseif ($notificationType == 3) {
            $clkAction = 'android.intent.action.QUIZ_MAIN_ACTIVITY';
        } elseif ($notificationType == 4) {
            $clkAction = 'QUIZ_CREATER_TEST_SERIES_LISTING';
        } elseif ($notificationType == 5) {
            $clkAction = 'android.intent.action.QUIZ_QUESTION_DETAILS';
        } else {
            $clkAction = 'android.intent.action.QUIZ_MAIN_ACTIVITY';
        }
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20)
            ->setPriority('high');
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
            ->setClickAction($clkAction)
            ->setSound('default');
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'title' => $title,
            'message' => $message,
            'type' => $notificationType,
            'notification_count' => $count,
            'record_id' => $record_id,
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        //  $tokens = "erzc_FmUdSQ:APA91bHAcG8FQehCYfcFxt-KQxrVJzpMzStgjXGoPEUGmQk2FB_muNhpd5hs7hI6Oy8WuFyKHEeMUoCMQOGbaQr85JyXSRp6GMzvZH90zvpcowrfQ3vxtNrgunEuoPQZmkGPu6iqCEk7";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        return $downstreamResponse;
    }
    public function notificationCount($userId)
    {
        $nCount = Notification::where(["user_id" => $userId, "is_read" => 0])->count();
        return $nCount;
    }

}
