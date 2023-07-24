<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\EnrolledUserController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test_paper', [QuestionController::class, 'test_paper']);
Route::post('enrollment', [EnrolledUserController::class, 'enrollment']);

Route::post('attempt', [EnrolledUserController::class, 'temp']);

Route::get('batches', [BatchController::class, 'batches_api']);

Route::post('course', [CourseController::class, 'addCourse']);


