<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Enroll;
use Illuminate\Http\Request;

class CourseEnrollmentController extends Controller
{
    public function __invoke(Announcement $announcement, Request $request)
    {



        // $enrollmentsCount = Enroll::where('announcement_id', $announcement->id)->count();



        if ($announcement->enroll()->count() > $announcement->student_count) {

            return response()->json([
                'error' => 'Sorry, enrollment for this announcement has reached its limit and is no longer accepting new enrollments.'
            ], 403);
        }


        return response()->json(['error' => 'Resource not found'], 404);

        Enroll::create([
            'user_id' => auth()->id(),
            'announcement_id' => $announcement->id,
        ]);
        return response()->noContent();
    }
}
