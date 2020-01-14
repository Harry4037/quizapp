<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::namespace("Api")->group(function() {

    if (\Request::segment(1) == "api") {
        $myfile = fopen(__DIR__ . "/../storage/input_data.txt", "a") or die("Unable to open file!");
        fwrite($myfile, "----------------------------------------------------");
        fwrite($myfile, "\n" . json_encode(date("d-m-Y H:i:s")));
        fwrite($myfile, "\n" . json_encode(\Request::segment(2)));
        fwrite($myfile, "\n" . json_encode($_REQUEST));
        fwrite($myfile, "\n");
        fwrite($myfile, "----------------------------------------------------");
        fwrite($myfile, "\n");
        fwrite($myfile, "----------------------------------------------------");
        fclose($myfile);
    }

    Route::post('/send-otp', 'AuthController@sendOTP');
    Route::post('/verify-otp', 'AuthController@verifyOTP');
    Route::post('/register', 'UserController@userRegister');
    Route::get('/user-profile', 'UserController@userProfile');
    Route::get('/question-list', 'QuestionController@questionList');
    Route::post('/submit-answer', 'QuestionController@submitQuestion');
    Route::get('/exam-list', 'ExamController@examList');
    Route::post('/like-question', 'QuestionController@likeQuestion');
    Route::get('/start-quiz', 'QuizController@startQuiz');
    Route::get('/subject-list', 'SubjectController@subjectList');
    Route::post('/comment', 'QuestionCommentController@comment');
    Route::get('/comment-list', 'QuestionCommentController@commentList');
    Route::get('/notification', 'NotificationController@notificationlist');

    
    Route::post('/create-quiz', 'QuizController@createQuiz');

    //UserController
    Route::post('/update-language', 'UserController@updateLanguage');
    Route::post('/update-exam-selection', 'UserController@updateExamSelection');

    //TestSeriesController
    Route::post('/create-test-series', 'TestSeriesController@createTestSeries');
    
    //QuestionController
    Route::post('/create-question', 'QuestionController@createQuestion');
    Route::post('/create-single-question', 'QuestionController@createSingleQuestion');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
