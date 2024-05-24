<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementsFeedContoller extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            Announcement::latest()->filter(request(['search', 'type' , 'field' , 'module']))->withCount(['like' , 'comment' , 'enroll'])->with('user.profile')->paginate(6)
        ]);
    }
}
