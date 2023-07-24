<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrolledUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\UserController;

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
    return view('admin.dashboard');
})->middleware('loginAuth');

Route::get('login', [UserController::class, 'login_page']);
Route::post('login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);

Route::get('add_course', [CourseController::class, 'add_course']);
Route::post('store_course', [CourseController::class, 'store']);
Route::get('course_list', [CourseController::class, 'course_list']);
Route::get('content_list', [CourseController::class, 'content_list']);

Route::get('add_question', [QuestionController::class, 'add_question'])->middleware('loginAuth');
Route::post('store_question', [QuestionController::class, 'store']);
Route::get('question_list', [QuestionController::class, 'question_list']);
Route::get('return_option', [QuestionController::class, 'return_option']);

Route::get('add_batch', [BatchController::class, 'add_batch']);
Route::post('store_batch', [BatchController::class, 'store']);
Route::get('batch_list', [BatchController::class, 'batch_list']);

Route::get('enrolled_user', [EnrolledUserController::class, 'enrolled_user_list']);

Route::get('change_status', [Controller::class, 'change_status']);

//User

Route::get('dashboard', [DashboardController::class, 'dashboard']);


///////////////////////////////////////// Course Routes ////////////////////////////////////

Route::post('course', [CourseController::class, 'addCourse']);
//Route::put('course', [CourseController::class, '']);
//Route::patch('course', [CourseController::class, '']);
//Route::delete('course/{id}', [CourseController::class, '']);
//Route::get('course/{id}', [CourseController::class, '']);
//Route::get('course', [CourseController::class, 'getAllCourse']);
