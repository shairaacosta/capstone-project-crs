<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AssessmentsController;
use \App\Http\Controllers\RegisterUsersController;




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
    $user = Auth::user();
    if(Auth::check()){
        if($user->hasRole('admin')){
            return redirect()->intended(RouteServiceProvider::HOME);
        }elseif ($user->hasRole('student')){
            return redirect()->route('student.dashboard');
        }
    }else{
        return redirect()->route('login');
    }

});

Route::post('/register_user',[RegisterUsersController::class,'registerUser'])->name('register_user');


require __DIR__.'/auth.php';

Route::group( ['middleware' => ['auth','role:admin']], function() {
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::resource('/users',  UsersController::class);
    Route::post('/import-users',  [UsersController::class,'importUsers'])->name('import-users');
    Route::get('/export-users-template',  [UsersController::class,'exportUsersTemplate'])->name('export-users-template');
    Route::resource('/permissions',  PermissionsController::class);
    Route::resource('/roles',  RolesController::class);
    Route::resource('/courses',  CoursesController::class);
    Route::resource('/categories',  CategoriesController::class);
    Route::resource('/exams',  ExamsController::class);
    Route::resource('/questions',  QuestionsController::class);
});
Route::group( ['middleware' => ['auth','role:student']], function() {
    Route::name('student.')->prefix('student')->group(function () {
        Route::get('/dashboard',[StudentDashboardController::class,'index'])->name('dashboard');
        Route::get('take_assessment',[AssessmentsController::class,'take_assessment'])->name('take_assessment');
        Route::get('course_list',[CoursesController::class,'courseList'])->name('course_list');
        Route::post('save_assessment_progress',[AssessmentsController::class,'saveAssessmentProgress'])->name('save_assessment_progress');
        Route::get('view_course_details/{id}',[CoursesController::class,'viewCourseDetails'])->name('view_course_details');
        Route::get('change_password',[UsersController::class,'changePassword'])->name('change_password');
        Route::post('store_new_password',[UsersController::class,'storeNewPassword'])->name('store_new_password');
        Route::post('submit_assessment',[AssessmentsController::class,'submitAssessment'])->name('submit_assessment');
        Route::get('view_assessment_results/{id}',[AssessmentsController::class,'viewAssessmentResults'])->name('view_assessment_results');
    });
});

Route::get('/clear-app',function(){
   Artisan::call('config:clear');
});
