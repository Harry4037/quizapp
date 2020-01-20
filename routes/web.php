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
        Route::get('/subject-questions', 'SubjectController@getSubjectQuestions')->name('admin.subject.questions');
    });

    // Exam Routes
    Route::prefix('exam')->group(function() {
        Route::get('/', 'ExamController@index')->name('admin.exam.index');
        Route::get('/list', 'ExamController@examList')->name('admin.exam.list');
        Route::match(['get', 'post'], '/add', 'ExamController@examAdd')->name('admin.exam.add');
        Route::match(['get', 'post'], '/edit/{exam}', 'ExamController@examEdit')->name('admin.exam.edit');
        Route::post('/delete', 'ExamController@examDelete')->name('admin.exam.delete');
        Route::get('/exam-questions', 'ExamController@getExamQuestions')->name('admin.exam.questions');
    });

});
