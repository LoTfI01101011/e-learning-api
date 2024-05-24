<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Like;
use Illuminate\Http\Request;

class CourseLikeController extends Controller
{
    public function store(Announcement $announcement, Request $request)
    {
        $like = Like::create([
            'user_id' => auth()->id(),
            'announcement_id' => $announcement->id,
        ]);

        return response()->json([
            $like, 200
        ]);
    }

    public function destroy(Announcement $announcement)
    {

        $like = $announcement->like()->where('user_id', auth()->id());
        $like->delete();
        return response()->noContent();
    }
}
