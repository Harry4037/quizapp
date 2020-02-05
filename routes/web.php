<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});
Route::namespace('Admin')->prefix('admin')->group(function() {
    Route::match(['get', 'post'], '/', 'LoginController@showLoginForm')->name('admin.login-form');
    Route::match(['get', 'post'], '/login', 'LoginController@login')->name('admin.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
});
Route::namespace('Admin')->middleware(['auth', 'role:Admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::match(['get', 'post'], '/profile', 'LoginController@profile')->name('admin.profile');
    Route::match(['get', 'post'], '/change-password', 'LoginController@changePassword')->name('admin.change-password');

    // User Routes
    Route::prefix('user')->group(function() {
        Route::get('/', 'UserController@index')->name('admin.user.index');
        Route::get('/list', 'UserController@userList')->name('admin.user.list');
        Route::match(['get', 'post'], '/add', 'UserController@userAdd')->name('admin.user.add');
        Route::match(['get', 'post'], '/edit/{user}', 'UserController@userEdit')->name('admin.user.edit');
        Route::post('/delete', 'UserController@userDelete')->name('admin.user.delete');
        Route::post('/status', 'UserController@userStatus')->name('admin.user.status');
        Route::post('/check-mobile-number', 'UserController@checkMobileNumber')->name('admin.user.check-mobile-no');
    });

    //creator
    Route::prefix('creator')->group(function() {
        Route::get('/', 'CreatorController@index')->name('admin.creator.index');
        Route::get('/list', 'CreatorController@userList')->name('admin.creator.list');
        Route::match(['get', 'post'], '/add', 'CreatorController@userAdd')->name('admin.creator.add');
        Route::match(['get', 'post'], '/edit/{user}', 'CreatorController@userEdit')->name('admin.creator.edit');
        Route::post('/delete', 'CreatorController@userDelete')->name('admin.creator.delete');
        Route::post('/status', 'CreatorController@userStatus')->name('admin.creator.status');
        Route::post('/check-mobile-number', 'CreatorController@checkMobileNumber')->name('admin.creator.check-mobile-no');
    });

    // Subject Routes
    Route::prefix('subject')->group(function() {
        Route::get('/', 'SubjectController@index')->name('admin.subject.index');
        Route::get('/list', 'SubjectController@subjectList')->name('admin.subject.list');
        Route::match(['get', 'post'], '/add', 'SubjectController@subjectAdd')->name('admin.subject.add');
        Route::match(['get', 'post'], '/edit/{subject}', 'SubjectController@subjectEdit')->name('admin.subject.edit');
        Route::post('/delete', 'SubjectController@subjectDelete')->name('admin.subject.delete');
    });

    // Exam Routes
    Route::prefix('exam')->group(function() {
        Route::get('/', 'ExamController@index')->name('admin.exam.index');
        Route::get('/list', 'ExamController@examList')->name('admin.exam.list');
        Route::match(['get', 'post'], '/add', 'ExamController@examAdd')->name('admin.exam.add');
        Route::match(['get', 'post'], '/edit/{exam}', 'ExamController@examEdit')->name('admin.exam.edit');
        Route::post('/delete', 'ExamController@examDelete')->name('admin.exam.delete');
    });

    // Question Routes
    Route::prefix('question')->group(function() {
        Route::get('/', 'QuestionController@index')->name('admin.question.index');
        Route::get('/list', 'QuestionController@questionList')->name('admin.question.list');
        Route::match(['get', 'post'], '/add', 'QuestionController@questionAdd')->name('admin.question.add');
        Route::match(['get', 'post'], '/edit/{question}', 'QuestionController@questionEdit')->name('admin.question.edit');
        Route::post('/delete', 'QuestionController@questionDelete')->name('admin.question.delete');
        Route::get('/question-exam', 'QuestionController@getQuestionExam')->name('admin.question.exam');
        Route::get('/question-subject', 'QuestionController@getQuestionSubject')->name('admin.question.subject');
        Route::post('/accept-ques', 'QuestionController@acceptQues')->name('admin.question.accept-ques');
        Route::post('/reject-ques', 'QuestionController@rejectQues')->name('admin.question.reject-ques');
        Route::get('/{question}/comment-list', 'QuestionController@comment')->name('admin.question.comment-list');
    });

    // Quiz Routes
    Route::prefix('quiz')->group(function() {
        Route::get('/', 'QuizController@index')->name('admin.quiz.index');
        Route::get('/list', 'QuizController@quizList')->name('admin.quiz.list');
        Route::match(['get', 'post'], '/add', 'QuizController@quizAdd')->name('admin.quiz.add');
        Route::match(['get', 'post'], '/edit/{quiz}', 'QuizController@quizEdit')->name('admin.quiz.edit');
        Route::match(['get', 'post'], '/question-list/{quiz}', 'QuizController@quizQuestionList')->name('admin.quiz.question-list');
        Route::match(['get', 'post'], '/question/add/{quiz}', 'QuizController@quizQuestionAdd')->name('admin.quiz.add-question');
        Route::match(['get', 'post'], '/question/edit/{question}', 'QuizController@quizQuestionEdit')->name('admin.quiz.edit-question');
        Route::post('/delete', 'QuizController@quizDelete')->name('admin.quiz.delete');
        Route::post('/delete-quiz-question', 'QuizController@deleteQuizQuestion')->name('admin.quiz.delete-question');
    });

    // Test Series Routes
    Route::prefix('test-series')->group(function() {
        Route::get('/', 'TestSeriesController@index')->name('admin.test-series.index');
        Route::get('/list', 'TestSeriesController@testSeriesList')->name('admin.test-series.list');
        Route::match(['get', 'post'], '/add', 'TestSeriesController@testSeriesAdd')->name('admin.test-series.add');
        Route::match(['get', 'post'], '/edit/{testseries}', 'TestSeriesController@testSeriesEdit')->name('admin.test-series.edit');
        Route::match(['get', 'post'], '/question-list/{testseries}', 'TestSeriesController@testSeriesQuestionList')->name('admin.test-series.question-list');
        Route::match(['get', 'post'], '/question/add/{testseries}', 'TestSeriesController@testSeriesQuestionAdd')->name('admin.test-series.add-question');
        Route::match(['get', 'post'], '/question/edit/{question}', 'TestSeriesController@testSeriesQuestionEdit')->name('admin.test-series.edit-question');
        Route::post('/delete', 'TestSeriesController@testSeriesDelete')->name('admin.test-series.delete');
        Route::post('/accept-series', 'TestSeriesController@acceptTestSeries')->name('admin.test-series.accept-ques');
        Route::post('/reject-series', 'TestSeriesController@rejectTestSeries')->name('admin.test-series.reject-ques');
    });

    // Notification Routes
    Route::prefix('notification')->group(function() {
        Route::get('/', 'NotificationController@index')->name('admin.notification.index');
        Route::get('/list', 'NotificationController@listNotification')->name('admin.notification.list');
        Route::post('/send-notification', 'NotificationController@sendNotification')->name('admin.notification.send');
        Route::get('/search-user', 'NotificationController@searchUser')->name('admin.notification.search-user');
    });
});
