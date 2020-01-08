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
    Route::get('/test-series', 'TestSeriesController@createTestSeries');
    Route::post('/create-quiz', 'QuizController@createQuiz');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
