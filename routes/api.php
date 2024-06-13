<?php

use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AnnouncementsFeedContoller;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CourseCommentController;
use App\Http\Controllers\Api\CourseEnrollmentController;
use App\Http\Controllers\Api\CourseLikeController;
use App\Http\Controllers\Api\CourseReplyController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\RateAndFeedbackController;
use App\Http\Controllers\Api\RateShowController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeacherUpgradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('auth/register', RegisterController::class);

Route::post('auth/login', LoginController::class);




Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', LogoutController::class);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user()->load('profile');
    });

    // Profile Routes

    Route::post('/profile', [ProfileController::class, 'store']);
    // here i use post method to update becuase laravel is not accepting form-data in the PUT/PATCH request  

    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/teacher/{teacher}', [TeacherController::class, 'show']);

    // become teacher
    // certificates here
    Route::post('/become-teacher', [TeacherUpgradeController::class, 'store'])->middleware('student');

    // rate & feedback teacher

    Route::post('/rates/{teacher}', [RateAndFeedbackController::class, 'store']);
    Route::patch('/rates/{rate}', [RateAndFeedbackController::class, 'update']);
    Route::delete('/rates/{rate}', [RateAndFeedbackController::class, 'destroy']);
    //show all the rates and feedbacks
    Route::get('/rates', [RateAndFeedbackController::class, 'show']);
    //show one rate with his feedback
    Route::get('/rate/{teacher}', RateShowController::class);
    //Courses

    Route::post('/announcements', [AnnouncementController::class, 'store'])->middleware('teacher');
    Route::patch('/announcements/{announcement}', [AnnouncementController::class, 'update'])->middleware('teacher');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->middleware('teacher');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show']);

    //Newsletter
    // You must run this in your terminal composer require mailchimp/marketing
    

    //route for spesific announcement with the liks and comments

    Route::post('/announcements/{announcement}/enrolls', CourseEnrollmentController::class)->middleware('student');

    // //likes + comments + replies

    Route::post('/announcements/{announcement}/likes', [CourseLikeController::class, 'store']);
    Route::delete('/announcements/{announcement}/likes', [CourseLikeController::class, 'destroy']);

    //comment

    Route::post('/announcements/{announcement}/comments', [CourseCommentController::class, 'store']);
    Route::patch('/comments/{comment}', [CourseCommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CourseCommentController::class, 'destroy']);

    //reply

    Route::post('/announcements/{announcement}/comments/{comment}/replies', [CourseReplyController::class, 'store']);
    Route::patch('replies/{reply}', [CourseReplyController::class, 'update']);
    Route::delete('replies/{reply}', [CourseReplyController::class, 'destroy']);
});

Route::post('/newsletter', NewsletterController::class);

Route::get('/feed', [AnnouncementsFeedContoller::class, 'index']);
